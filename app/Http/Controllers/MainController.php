<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MainController extends Controller
{
    public function __invoke()
    {
        $posts = Product::with('image')->take(10)->get();

        return view('main')->with([
            'title' => 'Divisima Shop',
            'posts' => $posts,
        ]);
    }
}
