<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            'product_id' => Product::inRandomOrder()->first(),
            'user_id'    => User::inRandomOrder()->first(),
            'text'       => $this->faker->realText(100),
            'rating'     => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
