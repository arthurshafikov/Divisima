<?php

namespace App\Http\Controllers;

use App\Includes\Cart;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function cart()
    {
        extract(Cart::getCartData());
        $title = 'Shopping Cart';
        return view('cart')->with(compact(Cart::CART_COMPACT_VARS, 'title'));
    }

    public function addToCart($id)
    {
        $items = Cart::addToCart($id);

        $response = new Response(Cart::getCartQtyCount($items));
        return $response->cookie(Cart::CART_COOKIE_NAME, json_encode($items), Cart::CART_COOKIE_TIME);
    }

    public function updateCart()
    {
        extract(Cart::updateCart());

        return response()
            ->json(['html' => $html, 'count' => $count])
            ->withCookie(Cart::CART_COOKIE_NAME, json_encode($cart), Cart::CART_COOKIE_TIME);
    }

    public static function resetCart()
    {
        Cart::resetCart();
        return redirect()->back()->with('msg', 'Cart was resetted!');
    }
}
