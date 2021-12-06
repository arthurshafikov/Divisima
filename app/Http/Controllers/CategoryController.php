<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function category(ProductFilter $filters, $slug): View
    {
        $category = Category::whereSlug($slug)->with('products')->firstOrFail();

        $products = $category
            ->products()
            ->filter($filters)
            ->with('image')
            ->paginate(setting('products_per_page'))
            ->appends(request()->input());

        return view('shop')->with([
            'title'   =>  $category->name,
            'products' => $products,
        ]);
    }
}
