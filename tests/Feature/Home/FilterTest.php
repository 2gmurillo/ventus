<?php

namespace Tests\Feature\Home;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * @dataProvider searchItemsProvider
     * @param string $field
     * @param string $value
     */
    public function itCanFilterProductsInHome(string $field, string $value)
    {
        //Arrange
        $user = User::factory()->create();
        Product::factory()->count(15)->create();
        $product = Product::factory()->create([
            'name' => 'Nombre del producto',
        ]);
        $filters[$field] = $value;

        //Act
        $response = $this->actingAs($user)
            ->get(route('home', $filters));
        $responseProducts = $response->getOriginalContent()['products'];

        //Assert
        $this->assertTrue($responseProducts->contains($product));
    }

    /** @test
     * @dataProvider notValidSearchDataProvider
     * @param string $field
     * @param null $value
     */
    public function itFailsWhenFilterProductsInHomeWithNotValidData(string $field, $value = null)
    {
        //Arrange
        $user = User::factory()->create();
        Product::factory()->count(15)->create();
        $data[$field] = $value;

        //Act
        $response = $this->actingAs($user)
            ->get(route('home', $data));

        //Assert
        $response->assertRedirect();
        $response->assertSessionHasErrors($field);
    }

    /**
     * @return array
     */
    public function notValidSearchDataProvider(): array
    {
        return [
            'Test name is too long' => ['search', Str::random(81)],
        ];
    }

    /**
     * @return array|string[]
     */
    public function searchItemsProvider(): array
    {
        return [
            'it can search products by name' => ['search', 'Nombre del producto'],
        ];
    }
}
