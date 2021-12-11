<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Includes\Cart;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function checkout(): View|RedirectResponse
    {
        $cartData = Cart::getCart();
        if (count($cartData['items']) < 1) {
            return redirect()->route('cart')->with('err', __('cart.empty'));
        }

        return view('checkout', [
            'title' => 'Checkout',
            'cartData' => $cartData,
            'profile' => optional(Auth::user())->profile,
        ]);
    }

    public function submit(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = app(OrderService::class)->createOrder(collect($request->validated()));

            return redirect()->route('thank-you', $order->id);
        } catch (Exception $e) {
            return redirect()->route('cart')->with('err', $e->getMessage());
        }
    }

    public function thank($id): View
    {
        return view('pages.thank-you', [
            'title' => __('order.thanks-title'),
            'id' => $id,
        ]);
    }

    public function order($id): View
    {
        $order = Order::findOrFail($id);

        return view('pages.order', [
            'title' => 'Your Order:',
            'order' => $order,
            'details' => [
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
            ],
        ]);
    }
}
