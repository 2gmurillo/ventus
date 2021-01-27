<?php

declare(strict_types=1);

namespace App\Factories\PaymentGateways;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\ConsumeExternalServices;
use Illuminate\Validation\ValidationException;

class PlacetoPay implements PaymentGatewayInterface
{
    use ConsumeExternalServices;

    protected $endpointBase;
    protected $login;
    protected $secretKey;
    protected const P2P_APPROVED = '00';
    protected const P2P_REJECTED = '?C';
    protected const P2P_EXPIRED = 'EX';
    protected const P2P_PENDING = 'PT';

    public function __construct()
    {
        $this->endpointBase = config('services.placetopay.endpoint_base');
        $this->login = config('services.placetopay.login');
        $this->secretKey = config('services.placetopay.secret_key');
    }

    public function resolveAuthorization(&$queryParameters): void
    {
        $credentials = $this->generateCredentials();
        $queryParameters['auth']['login'] = $this->login;
        $queryParameters['auth']['tranKey'] = $credentials['tranKey'];
        $queryParameters['auth']['nonce'] = $credentials['nonce'];
        $queryParameters['auth']['seed'] = $credentials['seed'];
    }

    public function generateCredentials(): array
    {
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }
        $nonceBase64 = base64_encode($nonce);
        $seed = date('c');
        $secretKey = $this->secretKey;
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        return [
            'tranKey' => $tranKey,
            'nonce' => $nonceBase64,
            'seed' => $seed,
        ];
    }

    public function decodeResponse($response)
    {
        return $response->json();
    }

    public function createPayment(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'description' => ['required'],
        ]);
        $reference = $order->id;
        $description = $request->description;
        $currency = 'USD';
        $total = $order->total;
        $p2pResponse = $this->createRequest($reference, $description, $currency, $total);
        if ($p2pResponse['status']['status'] != 'OK') {
            throw ValidationException::withMessages([
                'gateway' =>
                    __('Order creation could not be completed')
            ]);
        }
        $order->quantity = $total;
        $order->status = Order::IN_PROCESS;
        $order->reference = $p2pResponse['requestId'];
        $order->process_url = $p2pResponse['processUrl'];
        $order->save();
        return redirect($order->process_url);
    }

    public function retryPayment(Order $order): RedirectResponse
    {
        return redirect($order->process_url);
    }

    public function createRequest(
        int $reference,
        string $description,
        string $currency,
        float $total
    )
    {
        $queryParameters['payment']['reference'] = $reference;
        $queryParameters['payment']['description'] = $description;
        $queryParameters['payment']['amount']['currency'] = $currency;
        $queryParameters['payment']['amount']['total'] = $total;
        $queryParameters['expiration'] = date('c', strtotime('+' . Order::EXPIRATION . 'minute'));
        $queryParameters['returnUrl'] = route('orders.show', $reference);
        $queryParameters['ipAddress'] = request()->ip();
        $queryParameters['userAgent'] = request()->header('User-agent');
        return $this->makeRequest(
            'post',
            '/api/session/',
            $queryParameters
        );
    }

    public function getPaymentInformation(int $reference): array
    {
        return $this->makeRequest(
            'post',
            '/api/session/' . $reference
        );
    }

    public function status(int $reference): string
    {
        $status = $this->getPaymentInformation($reference)['status']['reason'];
        switch ($status) {
            case self::P2P_APPROVED:
                return Order::APPROVED;
            case self::P2P_REJECTED:
            case self::P2P_EXPIRED:
                return Order::REJECTED;
            case self::P2P_PENDING:
                return Order::PENDING;
            default:
                return Order::IN_PROCESS;
        }
    }
}
