<?php

namespace App\Http\Controllers;

use App\Jobs\TestEmailJob;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function contact()
    {
        return view('pages.contact')->with([
            'title' => 'Contact us', 
        ]);
    }

}
