<?php

namespace App\Reporters;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryReporter
{
    public function getTopSellingCategories(): Collection
    {
        return Category::query()
            ->select([
                'categories.id',
                'categories.name',
                DB::raw("SUM(products.total_sales) as sales"),
            ])
            ->rightJoin('category_product', 'categories.id', '=', 'category_product.category_id')
            ->join('products', 'products.id', '=', 'category_product.product_id')
            ->groupBy('categories.id')
            ->orderBy('sales', 'desc')
            ->take(12)
            ->get();
    }
}
