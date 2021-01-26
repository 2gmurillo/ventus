<?php

declare(strict_types=1);

namespace App\Facades;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class CartService
{
    public static function getCartFromUser(): ?Cart
    {
        return auth()->user()->carts()->first();
    }

    public static function getCartFromUserOrCreate(): Cart
    {
        $cart = CartService::getCartFromUser();
        return $cart ?? auth()->user()->carts()->create();
    }

    public static function store(Cart $cart, Product $product): void
    {
        $quantity = CartService::quantity($cart, $product);
        if ($product->stock < $quantity + 1) {
            throw ValidationException::withMessages([
                'product' =>
                    __("There is not enough stock for the quantity you required of {$product->name}")
            ]);
        }
        $cart->products()->syncWithoutDetaching([
            $product->id => ['quantity' => $quantity + 1]
        ]);
        Alert::toast('Producto añadido al carrito');
    }

    public static function delete(Cart $cart, Product $product): void
    {
        $quantity = CartService::quantity($cart, $product);
        if ($quantity < 2) {
            throw ValidationException::withMessages([
                'product' =>
                    __("You can't have zero quantity of the product")
            ]);
        }
        $cart->products()->syncWithoutDetaching([
            $product->id => ['quantity' => $quantity - 1]
        ]);
    }

    public static function quantity($cart, $product): int
    {
        return $cart->products()
                ->find($product->id)
                ->pivot
                ->quantity ?? 0;
    }
}
