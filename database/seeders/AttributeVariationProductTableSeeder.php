<?php

namespace Database\Seeders;

use App\Models\Attributes\AttributeVariation;
use App\Models\Product;
use Illuminate\Database\Seeder;

class AttributeVariationProductTableSeeder extends Seeder
{
    public function run()
    {
        $attributes = AttributeVariation::all();

        foreach (Product::all() as $product) {
            $product->attributeVariations()->attach($attributes->random(10)->pluck('id')->toArray());
        }
    }
}
