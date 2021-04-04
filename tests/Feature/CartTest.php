<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CartTest extends TestCase
{
    // use WithoutMiddleware;

    public function testGetCart()
    {
        $response = $this->withCookie('cart', '[]')->get(route('cart'));

        $response->assertSee('Your cart is empty!');
        $response->assertStatus(200);
        
        
        $response = $this->withCookie('cart', '124!@#1[]{7929asfjHSKFAL:SFKAK:WYRAI_@$&^QWIE#YQWPOUERTIHNFAS')->get(route('cart'));
        
        $response->assertSee('Your cart is empty!');
        $response->assertStatus(200);

        $cart = '{"241241214":{"1fa":"1","2312":"","color":""},"1":{"qty":"1","size":"","color":""} }';
        $response = $this->withCookie('cart', $cart)->get(route('cart'));
        
        $response->assertSee('Your cart is empty!');
        $response->assertStatus(200);
        
        $id = Product::inRandomOrder()->first()->id;
        $cart = '{"'.$id.'":{"qty":"2","size":"","color":""} }';
        $response = $this->withCookie('cart', $cart)->get(route('cart'));
        
        $response->assertSee('Total');
        $response->assertStatus(200);
    }

    public function testAddToCart()
    {
        $id = Product::inRandomOrder()->first()->id;
        $response = $this->get(route('addToCart', [
            'id' => $id,
        ]));
        $response->assertOk();

        $response = $this->get(route('addToCart', [
            'id' => $id,
            'size' => 'fasQ#J#!I@DSAF',
            'color' => '12fasQ#412J1#24!1I@124124DSAF',
        ]));

        $response->assertStatus(500);
    }

    public function testResetCart()
    {
        
        $cart = '{"1":{"qty":"2","size":"","color":""} }';
        $response = $this->withCookie('cart', $cart)->get(route('resetCart'));

        $response->assertCookie('cart', '[]');
        $response->assertSessionHas('msg');
        // $response->assertRedirect();
    }

    public function testUpdateCart()
    {
        $products = Product::inRandomOrder()->take(4)->get();

        $items = [];
        foreach ($products as $product) {
            $items[] = [
                'id' => $product->id,
                'qty' => '1',
                'size' => '',
                'color' => '',
            ];
        }
        $response = $this->get(route('updateCart', [
            'items' => $items,
        ]));

        $response->assertJsonCount(2);
        $response->assertCookie('cart');
    }
}
