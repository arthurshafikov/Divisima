<?php

namespace App\Http\ViewComposers;

use App\Includes\CookieHelper;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class RecentlyViewed
{
    public function compose(View $view)
    {
        $viewedCookie = CookieHelper::getJSONCookie('watched');
        if ($viewedCookie == false) {
            $viewedCookie = [];
        }
        $viewed = Product::with('image')->whereIn('id', $viewedCookie)->get();

        $view->with('viewed', $viewed);
    }
}
