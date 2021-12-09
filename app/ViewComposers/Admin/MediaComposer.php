<?php

namespace App\ViewComposers\Admin;

use App\Models\Image;
use Illuminate\Contracts\View\View;

class MediaComposer
{
    public function compose(View $view)
    {
        $images = Image::orderBy('created_at', 'desc')->paginate(20);
        $view->with('images', $images);
    }
}
