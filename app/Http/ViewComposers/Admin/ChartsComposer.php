<?php

namespace App\Http\ViewComposers\Admin;

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

                $ordersThisDay = Order::whereDay('created_at', date('d', $day))->with('products');

                $income = 0;
                $ordersThisDay->get()->each(function ($order) use (&$income) {
                    $income += $order->total;
                });
                $revenue[] = $income;
            }
            return compact('dates', 'revenue');
        });

        extract($shopRevenue);

        $view->with('revenue', $revenue);
        $view->with('dates', $dates);



        $shopOrders = Cache::remember('shop_orders', env("CACHE_TIME", 0), function () {
            $orders = [];
            $months = [];
            for ($i = 0; $i < 6; $i++) {
                $diff = 5 - $i;
                $month = strtotime("-{$diff} month");
                $months[] = date('F', $month);

                $ordersThisMonth = Order::whereMonth('created_at', date('m', $month))->with('products');
                $countOrders = $ordersThisMonth->count();
                $orders[] = $countOrders;
            }
            return compact('orders', 'months');
        });

        extract($shopOrders);

        $view->with('months', $months);
        $view->with('orders', $orders);
    }
}
