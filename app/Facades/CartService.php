<?php

namespace App\Facades;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Facade;
use RealRashid\SweetAlert\Facades\Alert;

class CartService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'cart';
    }

    /* Returns null or a Cart model instance */
    public static function getCartFromUser()
    {
        return auth()->user()->carts()->first();
    }

    public static function getCartFromUserOrCreate(): Cart
    {
        $cart = CartService::getCartFromUser();
        return $cart ?? auth()->user()->carts()->create();
    }

    public static function addOne(Cart $cart, Product $product)
    {
        Alert::success(__('producto agregado al carrito'));
    }
}
