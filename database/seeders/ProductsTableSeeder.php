<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(30)->create();
        
        $category = \App\Models\Category::all();
        
        Product::all()->each(function ($product) use ($category){
            for($i = 0; $i < 2; $i++){
                $product->category()->attach($category->random());
            }
        });

    }
}
