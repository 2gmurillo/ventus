<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\CartService;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class ProductCartController extends Controller
{
    /**
     * Adds a unit of the specified product in the cart.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function addProductToCart(Product $product): RedirectResponse
    {
        $cart = CartService::getCartFromUserOrCreate();
        CartService::store($cart, $product);
        return back();
    }
}
