<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;

class AttributesTableSeeder extends Seeder
{
    public function run()
    {
        $attributeVariations = [
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
        foreach ($attributeVariations as $attribute => $variations) {
            $attributeModel = Attribute::create([
                'name' => $attribute,
            ]);

            foreach ($variations as $variation) {
                AttributeVariation::create([
                    'attribute_id' => $attributeModel->id,
                    'name' => $variation,
                ]);
            }
        }
    }
}
