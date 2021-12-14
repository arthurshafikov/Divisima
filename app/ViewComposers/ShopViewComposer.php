<?php

namespace App\ViewComposers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class ShopViewComposer
{
    public function compose(View $view)
    {
        $minProductPrice = Cache::remember('minProductPrice', env("CACHE_TIME", 0), function () {
            return Product::min('price');
        });
        $view->with('minPrice', $minProductPrice);

        $maxProductPrice = Cache::remember('minProductPrice', env("CACHE_TIME", 0), function () {
            return Product::max('price');
        });
        $view->with('maxPrice', $maxProductPrice);

        $categories = Cache::remember('allCategoriesWithChilds', env("CACHE_TIME", 0), function () {
            return Category::with('childs')->parents()->get();
        });
        $view->with('categories', $categories);
    }
}
