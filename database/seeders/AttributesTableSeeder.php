<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;

use App\Models\Product;


class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'size' => [
                'xs',
                's',
                'm',
                'l',
                'xl',
                'xxl',
            ],
            'color' => [
                'gray',
                'orange',
                'yellow',
                'green',
                'purple',
                'blue',
            ],
            'brand' => [
                'Abercrombie & Fitch',
                'Asos',
                'Bershka',
                'Missguided',
                'Zara',
            ],
        ];
        foreach ($arr as $attribute => $variations) :
            $ans = Attribute::create([
                'name' => $attribute,
            ]);
            $id = $ans->id;
            
            foreach ($variations as $var) {
                AttributeVariation::create([
                    'attribute_id' => $id,
                    'name'         => $var,
                ]);
            }
        endforeach;

        $products = Product::all();

        $attributes = AttributeVariation::all();

        foreach ($products as $product) {
            $product->attributes()->attach($attributes->random(10)->pluck('id')->toArray());
        }
    }
}
