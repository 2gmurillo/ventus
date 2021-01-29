<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\CartService;
use App\Factories\PaymentGateways\PaymentGatewayFactory;
use App\Http\Requests\PaymentGatewayRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Product;
use App\Traits\UpdateOrderStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    use UpdateOrderStatus;

    public function index(): View
    {
        return view('orders.index', [
            'orders' => Order::getCachedOrders(),
        ]);
    }

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
        Product::flushCache();
        Order::flushCache();
        return $paymentGateway->createPayment($request, $order);
    }

    public function edit(Order $order): View
    {
        return view('orders.edit', [
            'order' => $order,
            'cartOrder' => CartService::getCartOrderFromUserOrCreate(),
            'paymentGateways' => PaymentGateway::all(),
        ]);
    }

    public function update(PaymentGatewayRequest $request, Order $order): RedirectResponse
    {
        $paymentGateway =
            PaymentGatewayFactory::create((int)$request->payment_gateway_id);
        $order = $this->updateOrderProducts($order);
        Product::flushCache();
        Order::flushCache();
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

    public function show(Order $order): View
    {
        $this->updateOrderStatus($order);
        return view('orders.show', ['order' => $order]);
    }

    public function updateOrderProducts(Order $order): Order
    {
        $cart = CartService::getCartOrderFromUser();
        $productsWithQuantity = CartService::getProductsWithQuantity($cart);
        $order->products()->detach();
        $order->products()->attach($productsWithQuantity->toArray());
        return $order;
    }
}
