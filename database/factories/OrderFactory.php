<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'    => User::inRandomOrder()->first(),
            'status'       => mt_rand(0, 3),
            'address'     => $this->faker->address,
            'country'     => $this->faker->country,
            'zip'     => $this->faker->postcode,
            'phone'     => $this->faker->phoneNumber,
            'subtotal'     => mt_rand(1000, 9999),
            'total'     => mt_rand(1000, 9999),
            'delivery' => $this->faker->word,
            'created_at' => $this->faker->dateTimeThisMonth(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating( function (Order $order) {
            for ($i = 0; $i < 4; $i++) {
                $order->products()->attach( Product::inRandomOrder()->first(), [
                    'qty' => $this->faker->numberBetween(1, 20),
                    'size' => 'M',
                    'color' => 'black',
                    'subtotal' => $this->faker->numberBetween(1, 9999),
                ]);
            }
        });
    }
}
