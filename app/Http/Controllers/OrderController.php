<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\CartService;
use App\Factories\PaymentGateways\PaymentGatewayFactory;
use App\Http\Requests\PaymentGatewayRequest;
use App\Models\PaymentGateway;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new order.
     *
     * @return Application|Factory|View
     * @throws ValidationException
     */
    public function create(): View
    {
        $cart = CartService::getCartFromUser();
        CartService::askForStock($cart);
        return view('orders.create', [
            'cart' => $cart,
            'paymentGateways' => PaymentGateway::all(),
        ]);
    }

    public function store(PaymentGatewayRequest $request): RedirectResponse
    {
        $paymentParameters = $this
            ->createPaymentParameters((int)$request->payment_gateway_id);
        $paymentGateway = $paymentParameters['paymentGateway'];
        $order = $paymentParameters['order'];
        return $paymentGateway->createPayment($request, $order);
    }

    public function createPaymentParameters(int $paymentGatewayId): array
    {
        $cart = CartService::getCartFromUser();
        $productsWithQuantity = CartService::getProductsWithQuantity($cart);
        $paymentGateway = PaymentGatewayFactory::create($paymentGatewayId);
        $order = auth()->user()->orders()
            ->create(['payment_gateway_id' => $paymentGatewayId]);
        $cart->products()->detach();
        $order->products()->attach($productsWithQuantity->toArray());
        return ['paymentGateway' => $paymentGateway, 'order' => $order];
    }
}
