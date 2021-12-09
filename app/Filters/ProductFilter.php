<?php

namespace App\Filters;

class ProductFilter extends QueryFilter
{
    public function priceMin($val)
    {
        return $this->builder->where([
            ['price', '>=', $val],
        ]);
    }

    public function priceMax($val)
    {
        return $this->builder->where([
            ['price', '<=', $val],
        ]);
    }

    public function brand($val)
    {
        return $this->builder->whereHas('attributeVariations', function ($query) use ($val) {
            $query->whereIn('slug', explode(',', $val));
        });
    }

    public function size($val)
    {
        return $this->builder->whereHas('attributeVariations', function ($query) use ($val) {
            $query->whereIn('slug', explode(',', $val));
        });
    }

    public function color($val)
    {
        return $this->builder->whereHas('attributeVariations', function ($query) use ($val) {
            $query->whereIn('slug', explode(',', $val));
        });
    }

    public function search($search)
    {
        $s = '%' . $search . '%';

        return $this->builder->where('name', 'LIKE', $s)
            ->orWhere('description', 'LIKE', $s)
            ->orWhere('details', 'LIKE', $s);
    }
}
