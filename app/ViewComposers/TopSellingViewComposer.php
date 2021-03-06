<?php

namespace App\ViewComposers;

use App\Reporters\CategoryReporter;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class TopSellingViewComposer
{
    public function compose(View $view)
    {
        $categories = Cache::remember('TopSellingCategories', env("CACHE_TIME", 0), function () {
            return app(CategoryReporter::class)->getTopSellingCategories();
        });
        $view->with('categories', $categories);
    }
}
