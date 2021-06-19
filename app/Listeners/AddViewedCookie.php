<?php

namespace App\Listeners;

use App\Events\ProductViewed;
use App\Includes\CookieHelper;

class AddViewedCookie
{
    public function handle(ProductViewed $event)
    {
        $id = $event->productId;
        CookieHelper::updateArrayCookie('watched', $id, 60 * 24, true);
    }
}
