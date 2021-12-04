<?php

namespace Tests\Integration\Service;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testIncrementProductsTotalSales()
    {
        $order = Order::factory()->create();
        $expected = $order->products->pluck('total_sales', 'id');
        $order->products->each(function (Product $product) use (&$expected) {
            $expected[$product->id] += $product->pivot->qty;
        });

        app(OrderService::class)->incrementProductsTotalSales($order);

        $result = $order->products->pluck('total_sales', 'id');
        $this->assertEquals($expected, $result);
    }
}
