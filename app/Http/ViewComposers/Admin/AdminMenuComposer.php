<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\Contracts\View\View;

class AdminMenuComposer
{
    public function compose(View $view)
    {
        $admin_menu = [
            'Core' => [
                [
                    'link' => 'admin',
                    'text' => 'Dashboard',
                    'icon' => 'fa-toolbox'
                ],
            ],
            'Interface' => [
                [
                    'text' => 'Products',
                    'link' => [
                        'products.index' => 'All Products',
                        'products.trash' => 'Trash',
                        'products.create' => 'Add Products',
                        'attributes.index' => 'Attributes',
                        'categories.index' => 'Categories',
                    ],
                    'icon' => 'fa-boxes',
                ],
                [
                    'text' => 'Posts',
                    'link' => [
                        'posts.index' => 'All Posts',
                        'posts.create' => 'Add Post',
                    ],
                    'icon' => 'fa-thumbtack',
                ],
                [
                    'text' => 'Slider',
                    'link' => [
                        'slider.index' => 'All Slides',
                        'slider.create' => 'Add Slide',
                    ],
                    'icon' => 'fa-image',
                ],
                [
                    'text' => 'Promocodes',
                    'link' => [
                        'promocodes.index' => 'All Promocodes',
                        'promocodes.create' => 'Add Promocode',
                    ],
                    'icon' => 'fa-tags',
                ],
            ],
            'Pages' => [
                [
                    'text' => 'Orders',
                    'link' => 'orders.index',
                    'icon' => 'fa-money-check-alt',
                ],
                [
                    'text' => 'Users',
                    'link' => 'users.index',
                    'icon' => 'fa-users',
                ],
                [
                    'text' => 'Menus',
                    'link' => 'menus.index',
                    'icon' => 'fa-bars',
                ],
                [
                    'text' => 'Options',
                    'link' => 'options',
                    'icon' => 'fa-cogs',
                ],
            ],


        ];
        $view->with('admin_menu',$admin_menu);
    }

    
}
