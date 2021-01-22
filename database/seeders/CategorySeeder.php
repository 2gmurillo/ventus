<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        $this->createFakerCategories();
    }

    /**
     * Creating a list of categories for Category seeder
     *
     * @return void
     */
    public function createFakerCategories(): void
    {
        $categories = [
            'Ropa deportiva',
            'Equipo de portivo',
            'Cuidado corporal',
            'Nutrición',
        ];
        for ($i = 0; $i < count($categories); $i++) {
            $category = new Category();
            $category->name = $categories[$i];
            $category->save();
        }
    }
}
