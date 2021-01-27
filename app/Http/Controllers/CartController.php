<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CartController extends Controller
{
    /**
     * Display a listing of products in specified cart.
     *
     * @return Application|Factory|View
     */
    public function index(): View
    {
        return view('carts.index', [
            'cart' => CartService::getCartFromUser()
        ]);
    }
}
