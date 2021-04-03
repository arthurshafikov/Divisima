<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Includes\CookieHelper;
use App\Models\Promocode;

class CartController extends Controller
{
    protected static $cookieName = 'cart';
    protected static $cookieTime = 60*24;

    protected static $compactVars = ['items','cart','subtotal','discount','total','promocode','numeric_total'];


    public function cart()
    {
        extract(self::getCartData());
        
        $title = 'Shopping Cart';

        return view('cart')->with(compact(self::$compactVars,'title'));
        
    }

    public static function getCount() : string
    {
        $cart = self::getCartCookie();
        
        if(!is_array($cart)){
            return 0;
        }
        $qty = self::getCartQtyCount($cart);
        return $qty > 99 ? '99+' : strval($qty);
    }
    
    public function addToCart(Request $request, $id)
    {
        Product::findOrFail($id);

        $qty = $request->qty ?? 1;
        $size = $request->size ?? '';
        $color = $request->color ?? '';

        $items = self::getCartCookie();
        if(!array_key_exists($id,$items)){

            if($color !== '' || $size !== ''){
                $attributes = getProductAttributes(['size','color'],$id);
                $variations = $attributes->pluck('name')->toArray();

                if( ( !in_array($size,$variations) && $size !== '-' ) 
                 || ( !in_array($color,$variations) && $color !== '-' ) ){
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
        $response = new Response(self::getCartQtyCount($items));
        return $response->cookie(self::$cookieName,json_encode($items),self::$cookieTime);
        
    }

    public static function getCartData()
    {
        $cart = self::getCartCookie();
        
        extract(self::countCartTotal($cart));

        return compact(self::$compactVars);
    }

    protected static function getCartCookie()
    {
        $cookie = self::$cookieName;
        $items = CookieHelper::getCookie($cookie,true);

        if(!is_array($items)){
            \Cookie::queue($cookie,json_encode([]),self::$cookieTime);
            return [];
        }

        if(count($items) > 0){
            foreach($items as $id => $item){
                if(!is_array($item) 
                || !array_key_exists('qty',$item) 
                || !array_key_exists('size',$item) 
                || !array_key_exists('color',$item) ){
                    \Cookie::queue($cookie,json_encode([]),self::$cookieTime);
                    return [];
                }
            }
        }
        return $items;
    }

    protected static function getCartQtyCount(array $cart) : int
    {
        $qty = 0;
        foreach($cart as $el){
            $qty += $el['qty'];
        }
        return $qty;
    }
    
    public function updateCart(Request $request)
    {
        $items = $request->input('items');
        $cart = [];
        foreach($items as $item){
            if($item['qty'] < 1){
                continue;
            }
            $cart[$item['id']] = [
                'qty' => $item['qty'],
                'size' => $item['size'],
                'color' => $item['color'],
            ];
        }
        
        extract(self::countCartTotal($cart));

        $html = view('parts.cart.cart',[
            'items' => $items,
            'cart'  => $cart,
            'total' => $total,
            'promocode' => $promocode,
        ])->render();
        return response()
            ->json(['html' => $html, 'count' => self::getCartQtyCount($cart)])
            ->withCookie(self::$cookieName,json_encode($cart),self::$cookieTime);
    }


    protected static function countCartTotal(array $cart) : array
    {
        $ids = array_keys($cart);
        $items = Product::with('image')->whereIn('id',$ids)->get();
        
        $cartTotal = 0;

        foreach($items as $product){
            $total = $product->price * $cart[$product->id]['qty'];
            $product['total'] = number_format($total,2);
            $product['number_subtotal'] = $total;
            $product['size'] = $cart[$product->id]['size'];
            $product['color'] = $cart[$product->id]['color'];
            $product['qty'] = $cart[$product->id]['qty'];
            $cartTotal += $total;
        }
        
        $promocode = false;
        $discount = 0;
        $subtotal = $cartTotal;
        if($discount = session('promocode')){
            $cartTotal = $cartTotal * ( 1 - $discount / 100);
            $discount = $subtotal - $cartTotal;
            $promocode = session('promocode');
        }
        $total = number_format($cartTotal,2);
        $numeric_total = round($cartTotal);

        return compact(self::$compactVars);
    }

    public static function resetCart()
    {
        \Cookie::queue(self::$cookieName,json_encode([]),0);
        return redirect()->back()->with('msg','Cart was resetted!');
    }

    
}
