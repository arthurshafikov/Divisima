<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\OrderService;

class IncrementProductsTotalSales
{
    public function handle(OrderPlaced $event)
    {
        app(OrderService::class)->incrementProductsTotalSales($event->order);
    }
}
