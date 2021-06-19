<?php

namespace App\Http\Controllers;

use App\Includes\CookieHelper;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    protected const WISHLIST_COOKIE_TIME = 60 * 24;
    protected const WISHLIST_COOKIE_NAME = 'wishlist';

    public function wishlist()
    {
        $product_ids = $this->getWishlistCookie();
        $products = Product::whereIn('id', $product_ids)->get();
        return view('pages.wishlist', [
            'title' => 'Wishlist',
            'products' => $products,
        ]);
    }

    public function addToWishlist($id)
    {
        Product::findOrFail($id);
        CookieHelper::updateArrayCookie(self::WISHLIST_COOKIE_NAME, $id, self::WISHLIST_COOKIE_TIME);
        return;
    }

    public function removeFromWishlist($id)
    {
        CookieHelper::removeFromArrayCookie(self::WISHLIST_COOKIE_NAME, $id, self::WISHLIST_COOKIE_TIME);
        return;
    }

    private function getWishlistCookie(): array
    {
        $minutes = self::WISHLIST_COOKIE_TIME;
        $cookie = self::WISHLIST_COOKIE_NAME;
        $items = CookieHelper::getCookie($cookie, true);

        if (!is_array($items)) {
            Cookie::queue($cookie, json_encode([]), $minutes);
            return [];
        }
        return $items;
    }
}
