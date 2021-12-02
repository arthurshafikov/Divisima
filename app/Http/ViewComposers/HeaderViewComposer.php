<?php

namespace App\Http\ViewComposers;

use App\Includes\Cart;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class HeaderViewComposer
{
    public function compose(View $view)
    {
        $cartCount = Cart::getCount();

        $menu = Cache::remember('HeaderMenu', env("CACHE_TIME", 0), function () {
            return Menu::where('location', 'header')->with('items')->first();
        });

        $view->with('menu', $menu);
        $view->with('cartCount', $cartCount);
    }
}
