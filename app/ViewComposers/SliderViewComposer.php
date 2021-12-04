<?php

namespace App\ViewComposers;

use App\Models\Slide;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class SliderViewComposer
{
    public function compose(View $view)
    {
        $slider = Cache::remember('HomeSlider', env("CACHE_TIME", 0), function () {
            return  Slide::with('image')->get();
        });
        $view->with('slider', $slider);
    }
}
