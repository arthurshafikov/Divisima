<?php

namespace App\Listeners;

use App\Events\ProductViewed;
use App\Includes\CookieHelper;

class AddViewedCookie
{
    public function handle(ProductViewed $event)
    {
        CookieHelper::updateArrayCookie('watched', $event->productId, 60 * 24, true);
    }
}
