<?php

declare(strict_types=1);

namespace App\Factories\PaymentGateways;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function createPayment(Request $request, Order $order): RedirectResponse;

    public function retryPayment(Order $order): RedirectResponse;

    public function getPaymentInformation(int $reference): array;

    public function status(int $reference): string;
}
