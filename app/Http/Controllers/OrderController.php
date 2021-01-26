<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\CartService;
use App\Models\PaymentGateway;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
}
