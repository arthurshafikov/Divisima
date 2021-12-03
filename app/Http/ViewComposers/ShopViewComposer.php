<?php

namespace App\Http\ViewComposers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class ShopViewComposer
{
    public function compose(View $view)
    {
        $menu = Cache::remember('ShopCategories', env("CACHE_TIME", 0), function () {
            $tree = getCategoryTree();
            return getMenu($tree, 'category-menu');
        });

        $minProductPrice = Cache::remember('minProductPrice', env("CACHE_TIME", 0), function () {
            return Product::min('price');
        });
        $maxProductPrice = Cache::remember('minProductPrice', env("CACHE_TIME", 0), function () {
            return Product::max('price');
        });

        $view->with('menu', $menu);
        $view->with('minPrice', $minProductPrice);
        $view->with('maxPrice', $maxProductPrice);
    }
}
