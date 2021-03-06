<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->realText(50),
            'content' => $this->faker->realText(8000),
            'image_id' => fn() => self::factoryForModel(Image::class),
            'created_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
