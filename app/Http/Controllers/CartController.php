<?php

namespace App\Http\Controllers;

use App\Includes\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CartController extends Controller
{
    public function cart(): View
    {
        return view('cart')->with(array_merge(Cart::getCart(), [
            'title' => __('cart.title'),
        ]));
    }

    public function addToCart($id): Response
    {
        Cart::addToCart($id);

        return new Response(Cart::getCartQtySum());
    }

    public function updateCart(): JsonResponse
    {
        $items = collect(request()->input('items'));

        $cart = Cart::updateCart($items);

        $cartData = $cart['cartData'];

        $html = view('parts.cart.cart', [
            'items' => $cartData['items'],
            'cart'  => $cartData['cart'],
            'total' => $cartData['total'],
            'promocode' => $cartData['promocode'],
        ])->render();

        return response()->json(['html' => $html, 'count' => $cart['count']]);
    }

    public static function resetCart(): RedirectResponse
    {
        Cart::resetCart();

        return redirect()->back()->with('msg', __('cart.reset'));
    }
}
