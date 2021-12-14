<?php

namespace Tests\Integration\Service;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        Event::fake();
        $checkoutFields = collect([
            'address' => 'someAddress',
            'country' => 'someCountry',
            'zip' => '12345',
            'phone' => '12345678910',
            'delivery' => Order::ORDER_COURIER_DELIVERY_METHOD,

            'first_name' => 'Mark',
            'surname' => 'Zuckerberg',
            'email' => 'mark.zuckerberg@fb.com',
            'name' => 'mark_zuckerberg',
            'password' => '12345678',
        ]);

        app(OrderService::class)->createOrder($checkoutFields);

        $this->assertDatabaseHas(Order::class, [
            'address' => 'someAddress',
            'country' => 'someCountry',
        ]);
        $this->assertDatabaseHas(User::class, [
            'email' => 'mark.zuckerberg@fb.com',
            'name' => 'mark_zuckerberg',
        ]);
        $this->assertDatabaseHas(Profile::class, [
            'first_name' => 'Mark',
            'surname' => 'Zuckerberg',
        ]);
        Event::assertDispatched(OrderPlaced::class);
    }

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
