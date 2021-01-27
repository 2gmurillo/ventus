<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aNotAdminUserCannotStoreAProduct()
    {
        //Arrange
        $user = User::factory()->create();

        //Act
        $response = $this->actingAs($user)
            ->get(route('admin.products.store'));

        //Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function anAdminCanStoreAProduct()
    {
        //Arrange
        $adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');
        $category = Category::factory()->create();
        $data = [
            'name' => 'Nombre',
            //'photo' => $file,
            'price' => 100,
            'category_id' => $category->id,
            'stock' => 10,
            'status' => 'available'
        ];

        //Act
        $this->actingAs($adminUser)
            ->post(route('admin.products.store', $data));

        //Assert
        //Storage::disk('public')->assertExists($file->hashName());
        $this->assertDatabaseHas('products', $data);
    }

    /** @test
     * @dataProvider notValidStoreDataProvider
     * @param string $field
     * @param mixed|null $value
     */
    public function anAdminCannotStoreAProductWhenDataIsNotValid(string $field, $value = null)
    {
        //Arrange
        $adminUser = User::factory()->create([
            'role' => 'admin',
        ]);
        $data[$field] = $value;

        //Act
        $response = $this->actingAs($adminUser)
            ->post(route('admin.products.store'), $data);

        //Assert
        $response->assertRedirect();
        $response->assertSessionHasErrors($field);
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
