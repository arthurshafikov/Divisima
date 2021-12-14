<?php

namespace App\Reporters;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryReporter
{
    public function getTopSellingCategories(): Collection
    {
        return Category::query()
            ->select([
                'categories.id',
                'categories.name',
            ])
            ->join('category_product', 'categories.id', '=', 'category_product.category_id')
            ->join('products', 'products.id', '=', 'category_product.product_id')
            ->orderBy('products.total_sales', 'desc')
            ->take(12)
            ->get();
    }
}
