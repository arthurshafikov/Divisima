<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class ShopViewComposer
{

    public function compose(View $view)
    {
        $menu = \Cache::remember('ShopCategories', env("CACHE_TIME", 0), function () {
            $tree = getCategoryTree();
            return getMenu($tree, 'category-menu');
        });
        $view->with('menu', $menu);
    }
}
