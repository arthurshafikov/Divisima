<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderOwnerCheck
{
    public function handle(Request $request, Closure $next)
    {
        $orderId = $request->route('orderId');

        $order = Order::findOrFail($orderId);
        if (Auth::id() !== $order->user->id) {
            abort(404);
        }

        return $next($request);
    }
}
