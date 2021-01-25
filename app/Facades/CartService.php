<?php

declare(strict_types=1);

namespace App\Facades;

use App\Models\Cart;
use App\Models\Product;
use RealRashid\SweetAlert\Facades\Alert;

class CartService
{
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

    public static function store(Cart $cart, Product $product)
    {
        Alert::toast('Producto añadido al carrito');
    }
}
