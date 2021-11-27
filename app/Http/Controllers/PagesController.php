<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PagesController extends Controller
{
    public function contact(): View
    {
        return view('pages.contact')->with([
            'title' => 'Contact us',
        ]);
    }
}
