<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItems;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'Header Menu',
                'location' => 'header',
            ],
            [
                'name' => 'Footer Menu',
                'location' => 'footer',
            ],
        ];
        foreach($menus as $menu){
            Menu::create($menu);
        }

        $items = [
            // Header Menu
            [
                'menu_id' => 1,
                'name' => 'Home',
                'path' => '/',
            ],
            [
                'menu_id' => 1,
                'name' => 'Shop',
                'path' => '/shop',
            ],
            [
                'menu_id' => 1,
                'name' => 'Contact',
                'path' => '/contact',
            ],
            [
                'menu_id' => 1,
                'name' => 'Blog',
                'path' => '/blog',
            ],
            [
                'menu_id' => 1,
                'name' => 'Women',
                'path' => '/category/women',
            ],
            [
                'menu_id' => 1,
                'name' => 'Men',
                'path' => '/category/men',
            ],
            [
                'menu_id' => 1,
                'name' => 'Jewelry',
                'path' => '/category/jewelry',
            ],
            [
                'menu_id' => 1,
                'name' => 'Shoes',
                'path' => '/category/shoes',
            ],
            // End Header Menu


            // Footer Menu
            [
                'menu_id' => 2,
                'name' => 'Home',
                'path' => '/',
            ],
            [
                'menu_id' => 2,
                'name' => 'Shop',
                'path' => '/shop',
            ],
            [
                'menu_id' => 2,
                'name' => 'Blog',
                'path' => '/blog',
            ],
            [
                'menu_id' => 2,
                'name' => 'Contact Us',
                'path' => '/contact',
            ],
            [
                'menu_id' => 2,
                'name' => 'Account',
                'path' => '/account',
            ],
            // End Footer Menu
        ];

        foreach($items as $item){
            MenuItems::create($item);
        }
    }
}
