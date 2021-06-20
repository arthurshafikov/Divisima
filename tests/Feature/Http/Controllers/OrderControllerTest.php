<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Product;
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
        $cart = '{"' . $product->id . '":{"qty":"2","size":"","color":""} }';

        $response = $this->withCookie('cart', $cart)->get(route('checkout'));

        $response->assertSee('Place Order');
        $response->assertOk();
    }

    public function testSubmitWithWrongCart()
    {
        $product = Product::factory()->create();
        $cart = '{"' . $product->id . '":{"qty":"2","size":"","color":""} }';

        $response = $this->withCookie('cart', $cart)->post(route('checkout'));

        $response->assertSessionHasErrors();
        $response->assertRedirect();
    }

    public function testSubmitWithoutNameAndEmail()
    {
        $product = Product::factory()->create();
        $cart = '{"' . $product->id . '":{"qty":"2","size":"","color":""} }';
        $order_info = [
            "address" => "testAddress",
            "country" => "testCountry",
            "zip" => "12412142",
            "phone" => "94124124124",
            "delivery" => "testDelivery",
            "first_name" => "testName",
            "surname" => "testSurname",
        ];

        $response = $this->withCookie('cart', $cart)->post(route('checkout'), $order_info);

        $response->assertSessionHasErrors(['name','email']);
        $response->assertRedirect();
    }

    public function testSubmit()
    {
        Mail::fake();
        $product = Product::factory()->create();
        $cart = '{"' . $product->id . '":{"qty":"2","size":"","color":""} }';
        $user = User::factory()->make();
        $order_info = [
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

        $response = $this->withCookie('cart', $cart)->post(route('checkout'), $order_info);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        Mail::assertSent(OrderMail::class, 2);
    }

    public function testEdit()
    {
        $order = Order::factory()->create();
        $admin = User::admin();

        $response = $this->actingAs($admin)
            ->patch(route('orders.update', $order->id), [
                'status' => Arr::random(Order::ORDER_STATUSES),
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message');
    }
}
