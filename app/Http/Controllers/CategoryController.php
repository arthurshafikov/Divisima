<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function category(string $slug): View
    {
        $category = Category::with('products')->whereSlug($slug)->firstOrFail();
        $products = $category
            ->products()
            ->filter(app(ProductFilter::class))
            ->with('image')
            ->paginate(setting('products_per_page'))
            ->appends(request()->input());

        return view('shop')->with([
            'title'   =>  $category->name,
            'products' => $products,
        ]);
    }
}
