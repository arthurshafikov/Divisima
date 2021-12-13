<?php

namespace App\Services;

use App\Includes\CookieHelper;

class ProductService
{
    public function addViewedCookie(int $productId): void
    {
        CookieHelper::addToArrayCookie('watched', $productId, 60 * 24, true);
    }
}
