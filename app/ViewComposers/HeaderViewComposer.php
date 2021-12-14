<?php

namespace App\ViewComposers;

use App\Includes\Cart;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class HeaderViewComposer
{
    public function compose(View $view)
    {
        $menu = Cache::remember('HeaderMenu', env("CACHE_TIME", 0), function () {
            return Menu::with('items')->whereLocation('header')->first();
        });
        $view->with('menu', $menu);

        $cartQtySum = Cart::getCartQtySum();
        $cartCount = $cartQtySum > 99 ? '99+' : strval($cartQtySum);
        $view->with('cartCount', $cartCount);
    }
}
