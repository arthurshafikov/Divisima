<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class TopSellingViewComposer
{
    public function compose(View $view)
    {
        $categories = Cache::remember('TopSellingCategories', env("CACHE_TIME", 0), function () {
            return  Category::take(12)->get();
        });
        $view->with('categories', $categories);
    }
}
