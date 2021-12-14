<?php

namespace Database\Factories\Attributes;

use App\Models\Attributes\Attribute;
use App\Models\Attributes\AttributeVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeVariationFactory extends Factory
{
    protected $model = AttributeVariation::class;

    public function definition(): array
    {
        return [
            'attribute_id' => fn() => self::factoryForModel(Attribute::class),
            'name' => $this->faker->word,
        ];
    }
}
