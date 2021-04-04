<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Models\Product;
use App\Includes\CookieHelper;

class RecentlyViewed
{

    public function compose(View $view)
    {
        $viewedCookie = CookieHelper::getCookie('watched', true);
        if ($viewedCookie == false) {
            $viewedCookie = [];
        }
        $viewed = Product::with('image')->whereIn('id', $viewedCookie)->get();
        
        $view->with('viewed', $viewed);
    }

    
}
