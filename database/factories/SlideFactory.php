<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slide::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(50),
            'content' => $this->faker->realText(200),
            'img' => Image::where('img', 'LIKE', '%jpeg%')->inRandomOrder()->first(),
        ];
    }
}
