<?php

namespace App\Http\Controllers;

use App\Includes\CookieHelper;
use App\Models\Product;

class WishlistController extends Controller
{
    protected static $cookieTime = 60*24;
    protected static $cookieName = 'wishlist';
    
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
        CookieHelper::updateArrayCookie(self::$cookieName, $id, self::$cookieTime);
        return;
    }

    public function getWishlistCookie() : array
    {
        $minutes = self::$cookieTime;
        $cookie = self::$cookieName;
        $items = CookieHelper::getCookie($cookie, true);

        if (!is_array($items)) {
            \Cookie::queue($cookie, json_encode([]), $minutes);
            return [];
        }
        return $items;
    }

    public function removeFromWishlist($id)
    {
        CookieHelper::removeFromArrayCookie(self::$cookieName, $id, self::$cookieTime);
        return;
    }
}
