<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeProductStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdminUserCanChangeProductStatus()
    {
        //Arrange
        $adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
        $category = Category::factory()->create();
        $productToUpdate = Product::factory()->create([
            'category_id' => $category->id
        ]);
        $previousState = $productToUpdate->status;

        //Act
        $this->actingAs($adminUser)
            ->patch(route('admin.products.status', $productToUpdate));

        //Assert
        $productToUpdate = $productToUpdate->refresh();
        $currentState = $productToUpdate->status;
        $this->assertNotEquals($previousState, $currentState);
    }

    /** @test */
    public function aNotAdminUserCannotChangeProductStatus()
    {
        //Arrange
        $authenticatedUser = User::factory()->create();
        $category = Category::factory()->create();
        $productToUpdate = Product::factory()->create([
            'category_id' => $category->id
        ]);
        $previousState = $productToUpdate->status;

        //Act
        $response = $this->actingAs($authenticatedUser)
            ->patch(route('admin.products.status', $productToUpdate));

        //Assert
        $productToUpdate = $productToUpdate->refresh();
        $currentState = $productToUpdate->status;
        $response->assertStatus(403);
        $this->assertEquals($previousState, $currentState);
    }
}
