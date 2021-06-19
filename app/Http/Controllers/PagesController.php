<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{

    public function contact()
    {
        return view('pages.contact')->with([
            'title' => 'Contact us',
        ]);
    }
}
