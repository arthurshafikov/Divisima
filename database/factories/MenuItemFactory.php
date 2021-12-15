<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition(): array
    {
        return [
            'menu_id' => fn() => self::factoryForModel(Menu::class),
            'name' => $this->faker->word(),
            'path' => $this->faker->domainWord(),
        ];
    }
}
