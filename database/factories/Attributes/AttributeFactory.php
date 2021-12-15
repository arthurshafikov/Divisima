<?php

namespace Database\Factories\Attributes;

use App\Models\Attributes\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
