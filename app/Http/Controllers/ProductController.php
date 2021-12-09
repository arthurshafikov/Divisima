<?php

namespace App\Http\Controllers;

use App\Events\ProductViewed;
use App\Filters\ProductFilter;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function one(string $slug): View
    {
        $product = Product::whereSlug($slug)->with(['images', 'attributeVariations.attribute'])->firstOrFail();

        event(new ProductViewed($product->id));

        $category = $product->category()->pluck('id')->toArray();
        $related = Product::whereHas('category', function ($query) use ($category) {
            $query->whereIn('id', $category);
        })->limit(10)->get();

        $rating = Review::where('product_id', $product->id)->pluck('rating');
        $ratingCount = count($rating);
        $rating = round($rating->avg());

        $brands = $this->getProductAttributeVariations($product)['brand'] ?? collect([]);

        return view('one')->with([
            'title'   => $product->name,
            'product' => $product,
            'related' => $related,
            'id'      => $product->id,
            'rating'  => $rating,
            'ratingCount' => $ratingCount,
            'brands' => $brands,
        ]);
    }

    public function shop(ProductFilter $filters): View
    {
        $products = Product::filter($filters)
            ->with('image')
            ->paginate(setting('products_per_page'))
            ->appends(request()->input());

        return view('shop')->with([
            'title'   =>  'Shop page',
            'products' => $products,
        ]);
    }

    public function getTopSellingProducts(Request $request): string
    {
        if ($category = $request->get('category')) {
            $products = Product::whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            })->orderBy('total_sales', 'DESC')->paginate(8);
        } else {
            $products = Product::orderBy('total_sales', 'DESC')->paginate(8);
        }

        return view('parts.product.product-loop', [
            'products' => $products,
        ])->render();
    }

    public function loadAttributes(int $id): string
    {
        $product = Product::with('attributeVariations.attribute')->findOrFail($id);

        return view('parts.product.attributes-select', [
            'product' => $product,
            'attributeVariations' => $this->getProductAttributeVariations($product),
        ])->render();
    }

    private function getProductAttributeVariations(Product $product): Collection
    {
        return $product->attributeVariations->groupBy(function ($attributeVariation) {
            return $attributeVariation->attribute->name;
        });
    }
}
