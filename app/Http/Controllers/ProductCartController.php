<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\CartService;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class ProductCartController extends Controller
{
    /**
     * Adds a unit of the specified product in the cart.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function addProductToCart(Product $product): RedirectResponse
    {
        $cart = CartService::getCartFromUserOrCreate();
        CartService::store($cart, $product);
        return back();
    }

    /**
     * Removes a unit of the specified product from the cart.
     *
     * @param Product $product
     * @param Cart $cart
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function removeProductFromCart(Product $product, Cart $cart): RedirectResponse
    {
        CartService::delete($cart, $product);
        return back();
    }
}
