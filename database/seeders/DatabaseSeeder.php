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
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            AttributesTableSeeder::class,
            SettingsTableSeeder::class,
        ]);

        if (app()->environment('local', 'development')) {
            $this->call([
                ImagesTableSeeder::class,
                ProductsTableSeeder::class,
                UsersTableSeeder::class,
                ReviewsTableSeeder::class,
                PostsTableSeeder::class,
                OrdersTableSeeder::class,
                SlidesTableSeeder::class,
                PromocodesTableSeeder::class,
            ]);
        }
    }
}
