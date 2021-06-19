<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            MenusTableSeeder::class,
            CategoriesTableSeeder::class,
            ImagesTableSeeder::class,
            ProductsTableSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
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
