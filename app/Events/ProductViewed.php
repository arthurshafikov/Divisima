<?php

namespace App\Events;

class ProductViewed
{
    public int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }
}
