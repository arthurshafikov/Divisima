<?php

namespace App\Includes;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class Cart
{
    public const CART_COMPACT_VARS = [
        'items',
        'cart',
        'subtotal',
        'discount',
        'total',
        'promocode',
        'numeric_total',
    ];
    public const CART_COOKIE_NAME = 'cart';
    public const CART_COOKIE_TIME = 60 * 24;

    public static function addToCart($id)
    {
        Product::findOrFail($id);
        $qty = request()->qty ?? 1;
        $size = request()->size ?? '';
        $color = request()->color ?? '';

        $items = self::getCartCookie();
        if (!array_key_exists($id, $items)) {
            if ($color !== '' || $size !== '') {
                $attributes = getProductAttributes(['size','color'], $id);
                $variations = $attributes->pluck('name')->toArray();

                if (( !in_array($size, $variations) && $size !== '-' )
                    || ( !in_array($color, $variations) && $color !== '-' )
                ) {
                    abort(500);
                }
            }
            $items[$id] = [
                'qty' => $qty,
                'size' => $size,
                'color' => $color,
            ];
        } else {
            $items[$id]['qty'] += $qty;
        }
        return $items;
    }

    public static function updateCart()
    {
        $items = request()->input('items');
        $cart = [];
        foreach ($items as $item) {
            if ($item['qty'] < 1) {
                continue;
            }
            $cart[$item['id']] = [
                'qty' => $item['qty'],
                'size' => $item['size'],
                'color' => $item['color'],
            ];
        }

        extract(Cart::countCartTotal($cart));

        $html = view('parts.cart.cart', [
            'items' => $items,
            'cart'  => $cart,
            'total' => $total,
            'promocode' => $promocode,
        ])->render();

        return [
            'html' => $html,
            'cart' => $cart,
            'count' => self::getCartQtyCount($cart),
        ];
    }

    public static function getCount(): string
    {
        $cart = self::getCartCookie();
        if (!is_array($cart)) {
            return 0;
        }
        $qty = self::getCartQtyCount($cart);
        return $qty > 99 ? '99+' : strval($qty);
    }

    public static function getCartData()
    {
        $cart = self::getCartCookie();
        extract(self::countCartTotal($cart));
        return compact(self::CART_COMPACT_VARS);
    }

    public static function resetCart()
    {
        Cookie::queue(self::CART_COOKIE_NAME, json_encode([]), 0);
    }

    public static function getCartCookie()
    {
        $cookie = self::CART_COOKIE_NAME;
        $items = CookieHelper::getCookie($cookie, true);
        if (!is_array($items)) {
            Cookie::queue($cookie, json_encode([]), self::CART_COOKIE_TIME);
            return [];
        }

        if (count($items) > 0) {
            foreach ($items as $id => $item) {
                if (!is_array($item) ||
                    !array_key_exists('qty', $item) ||
                    !array_key_exists('size', $item) ||
                    !array_key_exists('color', $item)
                ) {
                    Cookie::queue($cookie, json_encode([]), self::CART_COOKIE_TIME);
                    return [];
                }
            }
        }
        return $items;
    }

    public static function getCartQtyCount(array $cart): int
    {
        $qty = 0;
        foreach ($cart as $el) {
            $qty += $el['qty'];
        }
        return $qty;
    }

    public static function countCartTotal(array $cart): array
    {
        $ids = array_keys($cart);
        $items = Product::with('image')->whereIn('id', $ids)->get();

        $cartTotal = 0;
        foreach ($items as $product) {
            $total = $product->price * $cart[$product->id]['qty'];
            $product['total'] = number_format($total, 2);
            $product['number_subtotal'] = $total;
            $product['size'] = $cart[$product->id]['size'];
            $product['color'] = $cart[$product->id]['color'];
            $product['qty'] = $cart[$product->id]['qty'];
            $cartTotal += $total;
        }

        $promocode = false;
        $discount = 0;
        $subtotal = $cartTotal;
        if ($discount = session('promocode')) {
            $cartTotal = $cartTotal * ( 1 - $discount / 100);
            $discount = $subtotal - $cartTotal;
            $promocode = session('promocode');
        }
        $total = number_format($cartTotal, 2);
        $numeric_total = round($cartTotal);

        return compact(self::CART_COMPACT_VARS);
    }
}
