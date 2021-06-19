<?php

namespace Database\Factories;

use App\Models\Promocode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromocodeFactory extends Factory
{
    protected $model = Promocode::class;

    public function definition()
    {
        return [
            'promocode' => $this->faker->word,
            'discount' => $this->faker->numberBetween(1, 100),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
