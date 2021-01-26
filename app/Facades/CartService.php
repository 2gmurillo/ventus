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
                Alert::error('No hay stock suficiente para agregar más cantidad de este producto')
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
                $cart->products()->detach($product->id),
                Alert::toast('Producto eliminado del carrito'),
            ]);
        }
        $cart->products()->syncWithoutDetaching([
            $product->id => ['quantity' => $quantity - 1]
        ]);
        Alert::toast('Producto removido del carrito');
    }

    public static function quantity(Cart $cart, Product $product): int
    {
        return $cart->products()
                ->find($product->id)
                ->pivot
                ->quantity ?? 0;
    }

    public static function countProducts(): int
    {
        $cart = CartService::getCartFromUser();
        if ($cart !== null) {
            return $cart->products->pluck('pivot.quantity')->sum();
        }
        return 0;
    }

    public static function askForStock(Cart $cart): void
    {
        foreach ($cart->products as $product) {
            $quantity = $product->pivot->quantity;
            if ($product->stock < $quantity) {
                throw ValidationException::withMessages([
                    Alert::error(__("There is not enough stock for the quantity you required of {$product->name}"))
                ]);
            }
        }
    }

    public static function getProductsWithQuantity(Cart $cart, bool $isCart = true): object
    {
        return $cart->products->mapWithKeys(function ($product) use ($isCart) {
            $quantity = $product->pivot->quantity;
            if ($isCart) {
                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        Alert::error(__("There is not enough stock for the quantity you required of {$product->name}"))
                    ]);
                }
                $product->decrement('stock', $quantity);
            }
            $element[$product->id] = ['quantity' => $quantity];
            return $element;
        });
    }
}
