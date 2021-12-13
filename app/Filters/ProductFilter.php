<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends QueryFilter
{
    public function priceMin(string $val): Builder
    {
        return $this->builder->where('price', '>=', $val);
    }

    public function priceMax(string $val): Builder
    {
        return $this->builder->where('price', '<=', $val);
    }

    public function brand(string $val): Builder
    {
        return $this->builder->whereHas('attributeVariations', function (Builder $query) use ($val) {
            $query->whereIn('slug', explode(',', $val));
        });
    }

    public function size(string $val): Builder
    {
        return $this->builder->whereHas('attributeVariations', function (Builder $query) use ($val) {
            $query->whereIn('slug', explode(',', $val));
        });
    }

    public function color(string $val): Builder
    {
        return $this->builder->whereHas('attributeVariations', function (Builder $query) use ($val) {
            $query->whereIn('slug', explode(',', $val));
        });
    }

    public function search(string $searchQuery): Builder
    {
        $search = "%$searchQuery%";

        return $this->builder->where('name', 'LIKE', $search)
            ->orWhere('description', 'LIKE', $search)
            ->orWhere('details', 'LIKE', $search);
    }
}
