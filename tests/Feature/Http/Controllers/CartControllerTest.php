<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Attributes\Attribute;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetEmptyCart()
    {
        $response = $this->withCookie('cart', '[]')->get(route('cart'));

        $response->assertSee('Your cart is empty!');
        $response->assertStatus(200);
    }

    public function testGetWrongCart()
    {
        $response = $this->withCookie(
            'cart',
            '124!@#1[]{7929asfjHSKFAL:SFKAK:WYRAI_@$&^QWIE#YQWPOUERTIHNFAS'
        )->get(route('cart'));

        $response->assertSee('Your cart is empty!');
        $response->assertStatus(200);
    }

    public function testGetCartWithWrongItems()
    {
        $product = Product::factory()->create();
        $product->forceDelete();
        $cart = '{"' . $product->id . '":{"1fa":"1","2312":"","color":""},"1":{"qty":"1","size":"","color":""} }';

        $response = $this->withCookie('cart', $cart)->get(route('cart'));

        $response->assertSee('Your cart is empty!');
        $response->assertStatus(200);
    }

    public function testGetCart()
    {
        $product = Product::factory()->create();
        $cart = '{"' . $product->id . '":{"qty":"2","attributes":{}} }';

        $response = $this->withCookie('cart', $cart)->get(route('cart'));

        $response->assertSee('Total');
        $response->assertStatus(200);
    }

    public function testAddToCart()
    {
        $product = Product::factory()->create();
        $response = $this->get(route('addToCart', [
            'id' => $product->id,
            'qty' => 5,
            'attributes' => [
                Attribute::SIZE_TYPE => 'M',
            ],
        ]));
        $response->assertOk();
    }

    public function testResetCart()
    {
        $cart = '{"1":{"qty":"2","size":"","color":""} }';

        $response = $this->withCookie('cart', $cart)->get(route('resetCart'));

        $response->assertCookie('cart', '[]');
        $response->assertSessionHas('msg');
    }

    public function testUpdateCart()
    {
        $products = Product::factory()->count(4)->create();
        $items = [];
        foreach ($products as $product) {
            $items[] = [
                'id' => $product->id,
                'qty' => '1',
                'attributes' => [
                    Attribute::SIZE_TYPE => '',
                    Attribute::COLOR_TYPE => '',
                ],
            ];
        }

        $response = $this->get(route('updateCart', [
            'items' => $items,
        ]));

        $response->assertJsonCount(2);
        $response->assertCookie('cart');
    }
}
