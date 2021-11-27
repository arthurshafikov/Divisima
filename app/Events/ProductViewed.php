<?php

namespace App\Events;

class ProductViewed
{
    public int $productId;

    public function __construct(int $id)
    {
        $this->productId = $id;
    }
}
