<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\CartService;
use App\Factories\PaymentGateways\PaymentGatewayFactory;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class ProductCartOrderController extends Controller
{
    /**
     * Updates or retry an order depending on order status.
     *
     * @param Order $order
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function storeCartOrder(Order $order): RedirectResponse
    {
        if ($order->status === Order::IN_PROCESS) {
            CartService::askForStock($order);
            $paymentGateway =
                PaymentGatewayFactory::create((int)$order->payment_gateway_id);
            return $paymentGateway->retryPayment($order);
        }
        $cartOrder = CartService::getCartOrderFromUserOrCreate();
        $productsWithQuantity =
            CartService::getProductsWithQuantity($order, false);
        $cartOrder->products()->detach();
        $cartOrder->products()->attach($productsWithQuantity->toArray());
        return redirect()->route('orders.edit', $order);
    }

    /**
     * Adds a unit of the specified product in the cart.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function addOne(Product $product): RedirectResponse
    {
        $cart = CartService::getCartOrderFromUser();
        CartService::store($cart, $product);
        return back();
    }

    /**
     * Removes a unit of the specified product in the cart.
     *
     * @param Product $product
     * @param Cart $cartOrder
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function removeOne(Product $product, Cart $cartOrder): RedirectResponse
    {
        CartService::delete($cartOrder, $product);
        return back();
    }
}
