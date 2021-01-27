<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanSeeAddToCartButtonInHome() //False positive.
    {
        //Arrange
        $user = User::factory()->create();
        Product::factory()->count(15)->create();

        //Act
        $response = $this->actingAs($user)
            ->get(route('home'));

        //Assert
        $response->assertOk();
        $response->assertViewIs('home');
    }

    /** @test */
    public function itCanStoreAProductInCartAndSeeCartWithAddedProducts()
    {
        $this->withoutExceptionHandling();
        //Arrange
        $user = User::factory()->create();
        Product::factory()->count(15)->create();
        $product = Product::first();

        //Act
        $this->actingAs($user)
            ->post(route('products.carts.addProductToCart', $product));
        $cart = Cart::first();
        $response = $this->actingAs($user)
            ->get(route('carts.index'));
        $responseCart = $response->getOriginalContent()['cart'];

        //Assert
        $response->assertOk();
        $response->assertViewIs('carts.index');
        $response->assertViewHas('cart');
        $this->assertEquals($responseCart->products->first()->id, $cart->products->first()->id);
    }
}
