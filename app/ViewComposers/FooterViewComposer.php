<?php

namespace App\ViewComposers;

use App\Models\Menu;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class FooterViewComposer
{
    public function compose(View $view)
    {
        $posts = Cache::remember('FooterPosts', env("CACHE_TIME", 0), function () {
            return Post::with('image')->orderBy('created_at', 'desc')->take(2)->get();
        });
        $view->with('posts', $posts);

        $menu = Cache::remember('HeaderMenu', env("CACHE_TIME", 0), function () {
            return Menu::where('location', 'footer')->with('items')->first();
        });

        $view->with('menu', $menu);
    }
}
