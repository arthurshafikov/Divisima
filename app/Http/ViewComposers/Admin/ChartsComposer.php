<?php

namespace App\Http\ViewComposers\Admin;

use App\Models\Order;
use Illuminate\Contracts\View\View;

class ChartsComposer
{
    public function compose(View $view)
    {
        
        
        $shop_revenue = \Cache::remember('shop_revenue', env("CACHE_TIME",0),function(){
            $dates = [];
            $revenue = [];
            for($i = 0; $i < 14; $i++){
                $diff = 13 - $i;
                $day = strtotime("-{$diff} day");
                $dates[] = date('M j',$day);

                $orders_this_day = Order::whereDay('created_at',date('d',$day))->with('products');

                $income = 0;
                $orders_this_day->get()->each(function($order) use (&$income) {
                    $income += $order->total;
                }); 
                $revenue[] = $income;
            }
            return compact('dates','revenue');
        });

        extract($shop_revenue);

        $view->with('revenue',$revenue);
        $view->with('dates',$dates);

       

        $shop_orders = \Cache::remember('shop_orders', env("CACHE_TIME",0),function(){
            $orders = [];
            $months = [];
            for($i = 0; $i < 6; $i++){
                $diff = 5 - $i;
                $month = strtotime("-{$diff} month");
                $months[] = date('F',$month);
    
                $orders_this_month = Order::whereMonth('created_at',date('m',$month))->with('products');
    
                $count_orders = $orders_this_month->count();
    
                $orders[] = $count_orders;
            }
            return compact('orders','months');
        });

        extract($shop_orders);

        $view->with('months',$months);
        $view->with('orders',$orders);
    }

    
}
