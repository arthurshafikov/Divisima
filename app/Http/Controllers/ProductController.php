<?php

namespace App\Http\Controllers;

use App\Events\ProductViewed;
use App\Filters\ProductFilter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function one(string $slug): View
    {
        $product = Product::whereSlug($slug)
            ->with(['images', 'reviews', 'attributeVariations.attribute'])
            ->firstOrFail();

        event(new ProductViewed($product->id));

        $category = $product->category()->pluck('id')->toArray();
        $related = Product::whereHas('category', function ($query) use ($category) {
            $query->whereIn('id', $category);
        })->limit(10)->get();

        $rating = $product->reviews->pluck('rating');

        return view('one')->with([
            'title'   => $product->name,
            'product' => $product,
            'related' => $related,
            'id'      => $product->id,
            'rating'  => round($rating->avg()),
            'ratingCount' => $rating->count(),
            'brands' => $this->getProductAttributeVariations($product)['brand'] ?? collect([]),
        ]);
    }

    public function shop(): View
    {
        $products = Product::filter(app(ProductFilter::class))
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
        $productsQuery = Product::query();
        if ($category = $request->get('category')) {
            $productsQuery = $productsQuery->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        }

        return view('parts.product.product-loop', [
            'products' => $productsQuery->orderBy('total_sales', 'DESC')->paginate(8),
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
