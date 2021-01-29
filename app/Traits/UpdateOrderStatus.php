<?php

declare(strict_types=1);

namespace App\Traits;

use App\Factories\PaymentGateways\PaymentGatewayFactory;
use App\Models\Order;
use App\Models\Product;

trait UpdateOrderStatus
{
    public function updateOrderStatus(Order $order): void
    {
        $previousOrderStatus = $order->status;
        if ($previousOrderStatus === Order::IN_PROCESS || ($previousOrderStatus === Order::PENDING)) {
            $paymentGateway = PaymentGatewayFactory::create($order->payment_gateway_id);
            $currentOrderStatus = $paymentGateway->status($order->reference);
            if ($previousOrderStatus !== $currentOrderStatus) {
                $order->status = $currentOrderStatus;
                $order->save();
            }
            if ($currentOrderStatus === Order::REJECTED) {
                foreach ($order->products as $product) {
                    $quantity = $product->pivot->quantity;
                    $product->increment('stock', $quantity);
                    Product::flushCache();
                }
            }
        }
    }
}
