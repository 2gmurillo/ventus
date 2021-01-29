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
        if (($previousOrderStatus === Order::IN_PROCESS) || ($previousOrderStatus === Order::PENDING)) {
            $paymentGateway = PaymentGatewayFactory::create($order->payment_gateway_id);
            $currentOrderStatus = $paymentGateway->status($order->reference);
            $this->compareStatuses($order, $previousOrderStatus, $currentOrderStatus);
            $this->returnProductsToStock($order, $currentOrderStatus);
        }
    }

    public function compareStatuses(Order $order, string $previousOrderStatus, string $currentOrderStatus): void
    {
        if ($previousOrderStatus !== $currentOrderStatus) {
            $order->status = $currentOrderStatus;
            $order->save();
            Order::flushCache();
        }
    }

    public function returnProductsToStock(Order $order, string $currentOrderStatus): void
    {
        if ($currentOrderStatus === Order::REJECTED) {
            foreach ($order->products as $product) {
                $quantity = $product->pivot->quantity;
                $product->increment('stock', $quantity);
                Product::flushCache();
            }
        }
    }
}
