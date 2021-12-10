<?php

namespace App\Services\Admin;

use App\Models\Product;

class ProductService
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function updateOrFill(array $params): Product
    {
        $this->product->fill($params);
        $this->product->save();

        if (!empty($params['gallery'])) {
            $this->product->images()->sync(explode(',', $params['gallery']));
        }
        $this->product->attributeVariations()->sync(data_get($params, 'attributes'));
        $this->product->category()->sync(data_get($params, 'category'));

        return $this->product;
    }

    public function forceDelete()
    {
        $this->product->forceDelete();
    }

    public function restore()
    {
        $this->product->restore();
    }
}
