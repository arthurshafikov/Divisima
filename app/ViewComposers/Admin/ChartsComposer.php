<?php

namespace App\ViewComposers\Admin;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class ChartsComposer
{
    public function compose(View $view)
    {
        $shopRevenue = Cache::remember('shop_revenue', env("CACHE_TIME", 0), function () {
            $dates = [];
            $revenue = [];
            for ($i = 0; $i < 14; $i++) {
                $diff = 13 - $i;
                $day = strtotime("-{$diff} day");
                $dates[] = date('M j', $day);

                $revenue[] = Order::with('products')
                    ->whereDay('created_at', date('d', $day))
                    ->get()
                    ->sum('total');
            }
            return compact('dates', 'revenue');
        });
        $view->with('dates', $shopRevenue['dates']);
        $view->with('revenue', $shopRevenue['revenue']);

        $shopOrders = Cache::remember('shop_orders', env("CACHE_TIME", 0), function () {
            $orders = [];
            $months = [];
            for ($i = 0; $i < 6; $i++) {
                $diff = 5 - $i;
                $month = strtotime("-{$diff} month");
                $months[] = date('F', $month);

                $orders[] = Order::with('products')
                    ->whereMonth('created_at', date('m', $month))
                    ->count();
            }
            return compact('orders', 'months');
        });

        $view->with('orders', $shopOrders['orders']);
        $view->with('months', $shopOrders['months']);
    }
}
