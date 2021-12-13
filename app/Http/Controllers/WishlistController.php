<?php

namespace App\Http\Controllers;

use App\Includes\CookieHelper;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class WishlistController extends Controller
{
    protected const WISHLIST_COOKIE_TIME = 60 * 24;
    protected const WISHLIST_COOKIE_NAME = 'wishlist';

    public function wishlist(): View
    {
        $productIds = $this->getWishlistCookie();
        $products = Product::whereIn('id', $productIds)->get();

        return view('pages.wishlist', [
            'title' => __('pages.wishlist.title'),
            'products' => $products,
        ]);
    }

    public function addToWishlist(int $productId): void
    {
        Product::findOrFail($productId);
        CookieHelper::addToArrayCookie(self::WISHLIST_COOKIE_NAME, $productId, self::WISHLIST_COOKIE_TIME);
    }

    public function removeFromWishlist(int $productId): void
    {
        CookieHelper::removeFromArrayCookie(self::WISHLIST_COOKIE_NAME, $productId, self::WISHLIST_COOKIE_TIME);
    }

    private function getWishlistCookie(): array
    {
        $minutes = self::WISHLIST_COOKIE_TIME;
        $cookie = self::WISHLIST_COOKIE_NAME;
        $items = CookieHelper::getJSONCookie($cookie);
        if (!is_array($items)) {
            Cookie::queue($cookie, json_encode([]), $minutes);
            return [];
        }

        return $items;
    }
}
