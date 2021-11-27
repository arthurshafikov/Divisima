<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::factory()->count(30)->create();

        $category = Category::all();

        Product::all()->each(function ($product) use ($category) {
            for ($i = 0; $i < 2; $i++) {
                $product->category()->attach($category->random());
            }
        });
    }
}
