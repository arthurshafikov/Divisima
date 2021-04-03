<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MenusTableSeeder::class,
            CategoriesTableSeeder::class,
            ImagesTableSeeder::class,
            ProductsTableSeeder::class,
            UsersTableSeeder::class,
            ReviewsTableSeeder::class,
            PostsTableSeeder::class,
            AttributesTableSeeder::class,
            OrdersTableSeeder::class,
            SlidesTableSeeder::class,
            OptionsTableSeeder::class,
            PromocodesTableSeeder::class,
        ]);
    }
}
