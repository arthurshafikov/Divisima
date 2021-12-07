<?php

namespace App\Includes;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class Cart
{
    private const CART_COOKIE_NAME = 'cart';
    private const CART_COOKIE_TIME = 60 * 24;
    private const CART_COOKIE_ITEM_QTY = 'qty';
    private const CART_COOKIE_ITEM_ATTRIBUTES = 'attributes';

    public static function addToCart(array $params, int $id): int
    {
        Product::findOrFail($id);
        $qty = $params['qty'];
        $attributes = data_get($params, 'attributes', []);

        $items = self::getCartCookie();
        if (!array_key_exists($id, $items)) {
            // todo make products with different attributes add normally
            $items[$id] = [
                self::CART_COOKIE_ITEM_QTY => $qty,
                self::CART_COOKIE_ITEM_ATTRIBUTES => $attributes,
            ];
        } else {
            $items[$id][self::CART_COOKIE_ITEM_QTY] += $qty;
        }

        CookieHelper::setJSONCookie(self::CART_COOKIE_NAME, $items, self::CART_COOKIE_TIME);

        return self::getCartQtySum($items);
    }

    public static function updateCart(Collection $items): array
    {
        $cart = self::getCartCookie();

        $cart = array_intersect_key($cart, $items->keyBy('id')->toArray());

        foreach ($items as $item) {
            $cart[$item['id']][self::CART_COOKIE_ITEM_QTY] = $item['qty'];
        }

        $cartData = self::getCart($cart);

        if ($items->isEmpty()) {
            self::resetCart();
        } else {
            CookieHelper::setJSONCookie(self::CART_COOKIE_NAME, $cartData['cart'], self::CART_COOKIE_TIME);
        }

        return [
            'cartData' => $cartData,
            'count' => self::getCartQtySum(),
        ];
    }

    public static function resetCart(): void
    {
        Cookie::queue(self::CART_COOKIE_NAME, json_encode([]), 0);
    }

    public static function getCartCookie(): array
    {
        $items = CookieHelper::getJSONCookie(self::CART_COOKIE_NAME);
        if (!is_array($items)) {
            self::resetCart();
            return [];
        }

        if (count($items) > 0) {
            foreach ($items as $item) {
                if (
                    !is_array($item) ||
                    !array_key_exists(self::CART_COOKIE_ITEM_QTY, $item) ||
                    !array_key_exists(self::CART_COOKIE_ITEM_ATTRIBUTES, $item)
                ) {
                    self::resetCart();
                    return [];
                }
            }
        }
        return $items;
    }

    public static function getCartQtySum(?array $cart = null): int
    {
        if (is_null($cart)) {
            $cart = self::getCartCookie();
        }

        $qty = 0;
        foreach ($cart as $item) {
            $qty += $item[self::CART_COOKIE_ITEM_QTY];
        }

        return $qty;
    }

    public static function getCart(?array $cart = null): array
    {
        if (is_null($cart)) {
            $cart = self::getCartCookie();
        }

        $ids = array_keys($cart);
        $products = Product::with('image')->whereIn('id', $ids)->get();

        $cartTotal = 0;
        $products->each(function (Product $product) use ($cart, &$cartTotal) {
            $total = $product->price * $cart[$product->id][self::CART_COOKIE_ITEM_QTY];
            $product['total'] = number_format($total, 2);
            $product['number_subtotal'] = $total;
            $product['attributes'] = data_get($cart, sprintf("%s.attributes", $product->id));
            $product['qty'] = $cart[$product->id][self::CART_COOKIE_ITEM_QTY];
            $cartTotal += $total;
        });

        $subtotal = $cartTotal;
        if ($discount = session('promocode')) {
            $cartTotal = $cartTotal * ( 1 - $discount / 100);
            $discount = $subtotal - $cartTotal;
            $promocode = session('promocode');
        }
        $total = number_format($cartTotal, 2);
        $numericTotal = round($cartTotal);

        return [
            'items' => $products,
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'promocode' => $promocode ?? false,
            'numericTotal' => $numericTotal,
        ];
    }
}
