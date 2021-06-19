<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\Contracts\View\View;

class MediaComposer
{
    public function compose(View $view)
    {
        $images = \App\Models\Image::orderBy('created_at', 'desc')->paginate(20);
        $view->with('images', $images);
    }
}
