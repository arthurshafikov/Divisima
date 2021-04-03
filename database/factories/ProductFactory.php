<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(30),
            'img'  => Image::where('img','NOT LIKE','%jpeg%')->inRandomOrder()->first()->id,
            'price' => $this->faker->numberBetween(1000,9999),
            'stock' => mt_rand(0,2),
            'description' => $this->faker->realText(250),
            'details' => $this->faker->realText(100),
            'total_sales' => $this->faker->numberBetween(1,9999),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->images()->sync(Image::inRandomOrder()->take(3)->pluck('id')->toArray());
        });
    }
}
