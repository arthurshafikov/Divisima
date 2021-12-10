<?php

namespace App\View\Components\Product;

use App\Models\Product;
use Illuminate\View\Component;

class Attributes extends Component
{
    public ?Product $product;

    public function __construct(
        ?Product $product = null
    ) {
        $this->product = $product;
    }

    public function render()
    {
        return view('admin.components.product.attributes');
    }
}
