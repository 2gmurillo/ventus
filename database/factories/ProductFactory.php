<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(1, true),
            'price' => $this->faker->numberBetween(10.00, 500.00),
            'category_id' => Category::factory(),
            'stock' => $this->faker->numberBetween(1, 100),
            'status' => Product::STATUSES['available']
        ];
    }
}
