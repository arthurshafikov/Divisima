<?php

namespace App\ViewComposers\Admin;

use Illuminate\Contracts\View\View;

class AdminMenuComposer
{
    public function compose(View $view)
    {
        $adminMenu = [
            'Core' => [
                [
                    'link' => 'admin',
                    'text' => __('admin/menu.dashboard'),
                    'icon' => 'fa-toolbox',
                ],
            ],
            'Interface' => [
                [
                    'text' => __('admin/menu.products.title'),
                    'link' => [
                        'products.index' => __('admin/menu.products.index'),
                        'products.trash' => __('admin/menu.products.trash'),
                        'products.create' => __('admin/menu.products.create'),
                        'attributes.index' => __('admin/menu.attributes.index'),
                        'categories.index' => __('admin/menu.categories.index'),
                    ],
                    'icon' => 'fa-boxes',
                ],
                [
                    'text' => __('admin/menu.posts.title'),
                    'link' => [
                        'posts.index' => __('admin/menu.posts.index'),
                        'posts.create' => __('admin/menu.posts.create'),
                    ],
                    'icon' => 'fa-thumbtack',
                ],
                [
                    'text' => __('admin/menu.slider.title'),
                    'link' => [
                        'slider.index' => __('admin/menu.slider.index'),
                        'slider.create' => __('admin/menu.slider.create'),
                    ],
                    'icon' => 'fa-image',
                ],
                [
                    'text' => __('admin/menu.promocodes.title'),
                    'link' => [
                        'promocodes.index' => __('admin/menu.promocodes.index'),
                        'promocodes.create' => __('admin/menu.promocodes.create'),
                    ],
                    'icon' => 'fa-tags',
                ],
            ],
            'Pages' => [
                [
                    'text' => __('admin/menu.pages.orders'),
                    'link' => 'orders.index',
                    'icon' => 'fa-money-check-alt',
                ],
                [
                    'text' => __('admin/menu.pages.users'),
                    'link' => 'users.index',
                    'icon' => 'fa-users',
                ],
                [
                    'text' => __('admin/menu.pages.menus'),
                    'link' => 'menus.index',
                    'icon' => 'fa-bars',
                ],
                [
                    'text' => __('admin/menu.pages.settings'),
                    'link' => 'settings',
                    'icon' => 'fa-cogs',
                ],
            ],


        ];
        $view->with('adminMenu', $adminMenu);
    }
}
