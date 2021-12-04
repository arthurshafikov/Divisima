<?php

namespace App\Events;

use App\Models\Order;

class OrderPlaced
{
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
