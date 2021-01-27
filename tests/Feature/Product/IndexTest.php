<?php

namespace Tests\Feature\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anNotAdminUserCannotListProductsInAdminPanel(): void
    {
        // Arrange
        $authenticatedUser = User::factory()->create([
            'role' => 'customer',
        ]);

        //Act
        $this->actingAs($authenticatedUser);
        $response = $this->get(route('admin.products.index'));

        //Assert
        $response->assertStatus(403);
    }
}
