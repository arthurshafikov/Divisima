<?php

namespace App\Events;

class ProductViewed
{
    public $productId;

    public function __construct($id)
    {
        $this->productId = $id;
    }
}
