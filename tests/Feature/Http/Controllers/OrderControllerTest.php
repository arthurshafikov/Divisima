<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function testCheckoutWithEmptyCart()
    {
        $response = $this->withCookie('cart', '[]')->get(route('checkout'));

        $response->assertRedirect();
        $response->assertSessionHas('err');
    }

    public function testCheckout()
    {
        $product = Product::factory()->create();
        $cart = '{"' . $product->id . '":{"qty":"2","attributes":{}} }';

        $response = $this->withCookie('cart', $cart)->get(route('checkout'));

        $response->assertSee('Place Order');
        $response->assertOk();
    }

    public function testSubmitWithWrongCart()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $checkoutFields = [
            "address" => "Moscow",
            "country" => "Russia",
            "zip" => "123456",
            "phone" => "899999999999",
            "delivery" => Order::ORDER_COURIER_DELIVERY_METHOD,
        ];
        $cart = [
            $product->id => [
                'qty' => 2,
                'attributes' => [
                    'color' => 'fsaafsfsa',
                    'size' => 'fasija',
                ],
            ],
        ];

        $response = $this->withCookie('cart', json_encode($cart))
            ->actingAs($user)
            ->post(route('checkout'), $checkoutFields);

        $response->assertSessionHas('err');
        $response->assertRedirect(route('cart'));
    }

    public function testSubmitWithoutNameAndEmail()
    {
        $product = Product::factory()->create();
        $cart = '{"' . $product->id . '":{"qty":"2","attributes":{}} }';
        $orderInfo = [
            "address" => "testAddress",
            "country" => "testCountry",
            "zip" => "12412142",
            "phone" => "94124124124",
            "delivery" => "testDelivery",
            "first_name" => "testName",
            "surname" => "testSurname",
        ];

        $response = $this->withCookie('cart', $cart)->post(route('checkout'), $orderInfo);

        $response->assertSessionHasErrors(['name','email']);
        $response->assertRedirect();
    }

    public function testSubmit()
    {
        Mail::fake();
        $product = Product::factory()->create();
        $cart = '{"' . $product->id . '":{"qty":"2","attributes":{}} }';
        $user = User::factory()->make();
        $orderInfo = [
            "address" => "testAddress",
            "country" => "testCountry",
            "zip" => "12412142",
            "phone" => "94124124124",
            "delivery" => 'courier',
            "first_name" => "testName",
            "surname" => "testSurname",
            'email' => $user->email,
            'name' => $user->name,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->withCookie('cart', $cart)->post(route('checkout'), $orderInfo);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        Mail::assertSent(OrderMail::class, 2);
    }

    public function testEdit()
    {
        $order = Order::factory()->create();
        $admin = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($admin)
            ->patch(route('orders.update', $order->id), [
                'status' => Arr::random(Order::ORDER_STATUSES),
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message');
    }
}
