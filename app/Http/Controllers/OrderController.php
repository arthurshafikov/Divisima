<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Http\Requests\CheckoutRequest;
use App\Includes\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function checkout()
    {
        $profile = optional(Auth::user())->profile;

        $cartData = Cart::getCart();

        if (count($cartData['items']) < 1) {
            return redirect()->route('cart')->with('err', 'You have no products in your cart!');
        }

        return view('checkout', [
            'title' => 'Checkout',
            'items' => $cartData['items'],
            'cart'  => $cartData['cart'],
            'subtotal' => $cartData['subtotal'],
            'discount' => $cartData['discount'],
            'total' => $cartData['total'],
            'profile' => $profile,
            'delivery' => Order::ORDER_DELIVERY_METHODS,
        ]);
    }

    public function submit(CheckoutRequest $request)
    {
        $data = $request->only('address', 'zip', 'phone', 'country', 'delivery', 'additional');

        $user = Auth::user();
        if ($user === null) {
            $userData = $request->only('email', 'name', 'password');
            $user = User::create($userData);
            Auth::attempt($request->only('email', 'password'));
        }

        $data['user_id'] = $user->id;

        $profileData = array_merge($request->only('first_name', 'surname', 'address', 'country', 'zip', 'phone'), [
            'user_id' => $data['user_id'],
        ]);
        $user->profile()->updateOrCreate($profileData);

        $cartData = Cart::getCart();

        $data['subtotal'] = $cartData['subtotal'];
        $data['discount'] = $cartData['discount'];
        $data['total'] = $cartData['numericTotal'];
        $ids = $cartData['items']->pluck('id')->toArray();
        $items = $cartData['items'];

        Product::whereIn('id', $ids)->each(function ($product) use ($items) {
            $product->total_sales += $items->where('id', $product->id)->first()['qty'];
            $product->save();
        });

        $order = Order::create($data);

        $items->each(function ($item) use ($order) {
            $order->products()->attach($item->id, [
                'qty' => $item['qty'],
                'size' => $item['size'],
                'color' => $item['color'],
                'subtotal' => $item['number_subtotal'],
            ]);
        });

        Cart::resetCart();
        event(new OrderPlaced($order));

        return redirect()->route('thank-you', $order->id);
    }

    public function thank($id): View
    {
        $this->checkOrderOwner($id);

        return view('pages.thank-you', [
            'title' => 'Thank you for the order!',
            'id' => $id,
        ]);
    }

    public function order($id): View
    {
        $order = $this->checkOrderOwner($id);

        $details = [
            'country' => $order->country,
            'address' => $order->address,
            'zip' => $order->zip,
            'phone' => $order->phone,
            'status' => $order->status_text,
            'delivery' => $order->delivery_text,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'total' => $order->formatted_total,
            'details' => $order->details,
        ];
        $products = $order->products;

        return view('pages.order', [
            'title' => 'Your Order:',
            'order' => $order,
            'details' => $details,
            'products' => $products,
        ]);
    }

    protected function checkOrderOwner($id): Order
    {
        // todo переделать
        $order = Order::findOrFail($id);
        if (Auth::id() !== $order->user->id) {
            abort(404);
        }
        return $order;
    }
}
