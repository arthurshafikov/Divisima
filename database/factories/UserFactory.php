<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->userName,//$this->faker->regexify('^[a-z0-9_-]{3,50}$')
            'password' => '123',
            'email' => $this->faker->unique()->safeEmail,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            Profile::factory()->for($user)->create();
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
                'email' => 'wolf-front@yandex.ru',
                'password' => '123',
                'email_verified_at' => now(),
            ];
        });
    }

    public function testUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'test',
                'email' => 'test@yandex.ru',
                'password' => '123',
            ];
        });
    }
}
