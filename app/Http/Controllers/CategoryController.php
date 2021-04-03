<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function category(ProductFilter $filters,$slug)
    {
        $category = Category::where('slug',$slug)->with('products')->firstOrFail();

        $products = Product::whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->filter($filters)->with('image')->paginate(self::$products_per_page)->appends(request()->input());

        return view('shop')->with([
            'title'   =>  $category->name,
            'products' => $products,
            'min_price' => Product::min('price'),
            'max_price' => Product::max('price'),
        ]);
    }
}
