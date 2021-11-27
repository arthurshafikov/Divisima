<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'img' => 'images/' . $this->faker->numberBetween(1, 19) . '.jpg',
        ];
    }

    public function onlyJpeg(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'img' => 'images/' . $this->faker->numberBetween(1, 2) . '.jpeg',
            ];
        });
    }
}
