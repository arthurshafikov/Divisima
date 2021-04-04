<?php

namespace Tests\Feature;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithFaker;

    public function testCheckout()
    {
        $cart = '[]';
        $response = $this->withCookie('cart', $cart)->get(route('checkout'));

        $response->assertRedirect();
        $response->assertSessionHas('err');

        $id = Product::inRandomOrder()->first()->id;
        $cart = '{"'.$id.'":{"qty":"2","size":"","color":""} }';
        $response = $this->withCookie('cart', $cart)->get(route('checkout'));

        $response->assertSee('Place Order');
        $response->assertOk();
    }
    
    public function testSubmit()
    {
        Mail::fake();

        $id = Product::inRandomOrder()->first()->id;
        $cart = '{"'.$id.'":{"qty":"2","size":"","color":""} }';
        $response = $this->withCookie('cart', $cart)->post(route('checkout'),[]);

        $response->assertSessionHasErrors();
        $response->assertRedirect();

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


        $user = User::factory()->make();
        $order_info['email'] = $user->email;
        $order_info['name'] = $user->name;
        $order_info['password'] = '12345678';
        $order_info['password_confirmation'] = '12345678';

        $response = $this->withCookie('cart', $cart)->post(route('checkout'), $order_info);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        Mail::assertSent(OrderMail::class, 2);
    }


    public function testEdit()
    {
        $order = Order::factory()->create();
        $admin = User::admin();

        $response = $this->patch(route('orders.update', $order->id),[]);

        $response->assertForbidden();


        $response = $this->actingAs($admin)
                            ->patch(route('orders.update', $order->id),[
                                'status' => mt_rand(1,3),
                            ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('message');
    }
}
