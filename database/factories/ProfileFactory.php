<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id'     => self::factoryForModel(User::class),
            'first_name'  => $this->faker->firstName(),
            'surname'     => $this->faker->lastName(),
            'address'     => $this->faker->address(),
            'country'     => $this->faker->country(),
            'zip'         => $this->faker->postcode(),
            'phone'       => $this->faker->phoneNumber(),
        ];
    }
}
