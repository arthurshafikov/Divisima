<?php

namespace Database\Factories;

use App\Models\Promocode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromocodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promocode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'promocode' => $this->faker->word,
            'discount' => $this->faker->numberBetween(1,100),
            'expired_at' => $this->faker->dateTimeBetween('now','+1 year'),
        ];
    }
}
