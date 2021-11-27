<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'product_id' => self::factoryForModel(Product::class),
            'user_id'    => self::factoryForModel(User::class),
            'text'       => $this->faker->realText(100),
            'rating'     => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
