<?php

namespace App\Listeners;

use App\Events\ProductViewed;
use App\Includes\CookieHelper;

class AddViewedCookie
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductViewed  $event
     * @return void
     */
    public function handle(ProductViewed $event)
    {
        $id = $event->productId;
        CookieHelper::updateArrayCookie('watched', $id, 60 * 24, true);
    }
}
