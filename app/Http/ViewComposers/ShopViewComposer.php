<?php

namespace App\Http\ViewComposers;

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
        $maxProductPrice = Cache::remember('minProductPrice', env("CACHE_TIME", 0), function () {
            return Product::max('price');
        });

        $categories = Cache::remember('allCategoriesWithChilds', env("CACHE_TIME", 0), function () {
            return Category::parents()->with('childs')->get();
        });
        $view->with('categories', $categories);
        $view->with('minPrice', $minProductPrice);
        $view->with('maxPrice', $maxProductPrice);
    }
}
