<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aNotAdminUserCannotUpdateAProduct()
    {
        // Arrange
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);
        $data = [
            'name' => 'Nombre',
            'price' => 100,
            'category_id' => $category->id,
            'stock' => 10,
            'status' => 'available'
        ];

        //Act
        $response = $this->actingAs($user)
            ->patch(route('admin.products.update', $product), $data);

        //Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function anAdminCanUpdateAProduct()
    {
        // Arrange
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);
        $data = [
            'name' => 'Nombre',
            'price' => 100,
            'category_id' => $category->id,
            'stock' => 10,
            'status' => 'available'
        ];

        // Act
        $response = $this->actingAs($user)
            ->patch(route('admin.products.update', $product), $data);
        $product = $product->refresh();

        // Assert
        $this->assertEquals('Nombre', $product->name);
        $this->assertEquals(100, $product->price);
        $this->assertEquals($category->id, $product->category_id);
        $this->assertEquals(10, $product->stock);
        $this->assertEquals('available', $product->status);
        $response->assertRedirect();
    }

    /** @test
     * @dataProvider notValidStoreDataProvider
     * @param string $field
     * @param mixed|null $value
     */
    public function anAdminCannotUpdateAProductWhenDataIsNotValid(string $field, $value = null)
    {
        // Arrange
        $adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);
        $data[$field] = $value;

        // Act
        $response = $this->actingAs($adminUser)
            ->post(route('admin.products.store'), $data);
        $product = $product->refresh();

        // Assert
        $response->assertRedirect();
        $response->assertSessionHasErrors($field);
        $this->assertNotEquals('Nombre', $product->name);
    }

    /**
     * @return array
     */
    public function notValidStoreDataProvider(): array
    {
        return [
            'Test name is required' => ['name', null],
            'Test name is too short' => ['name', 'na'],
            'Test name is too long' => ['name', Str::random(81)],
        ];
    }
}
