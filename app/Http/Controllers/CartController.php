<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
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

    public function addToCart(AddToCartRequest $request, int $id): Response
    {
        $cartQuantity = Cart::addToCart($request->validated(), $id);

        return new Response($cartQuantity);
    }

    public function removeFromCart(int $id): Response
    {
        $cartQuantity = Cart::removeFromCart($id);

        return new Response($cartQuantity);
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
