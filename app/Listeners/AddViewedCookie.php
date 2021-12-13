<?php

namespace App\Listeners;

use App\Events\ProductViewed;
use App\Services\ProductService;

class AddViewedCookie
{
    public function handle(ProductViewed $event)
    {
        app(ProductService::class)->addViewedCookie($event->productId);
    }
}
