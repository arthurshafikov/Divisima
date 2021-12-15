<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->userName(),
            'password' => '123',
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (User $user) {
            Profile::factory()->for($user)->create();
        });
    }
}
