<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WishlistControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddToWishlist()
    {
        $product = Product::factory()->create();
        $expected = [
            "$product->id",
        ];

        $response = $this->get(route('addToWishlist', [
            'id' => $product->id,
        ]));

        $response->assertCookie('wishlist', json_encode($expected));
        $response->assertOk();
    }

    public function testEmptyWishlist()
    {
        $wishlist = [];

        $response = $this->withCookie('wishlist', json_encode($wishlist))->get(route('wishlist'));

        $response->assertOk();
        $response->assertSee('You have not added any products to your wishlist yet.');
    }

    public function testWishlist()
    {
        $product = Product::factory()->create();
        $wishlist = [
            $product->id
        ];

        $response = $this->withCookie('wishlist', json_encode($wishlist))->get(route('wishlist'));

        $response->assertOk();
        $response->assertSee($product->name);
    }

    public function testRemoveFromWishlist()
    {
        $product = Product::factory()->create();
        $wishlist = [
            $product->id,
        ];
        $expected = [];

        $response = $this->withCookie('wishlist', json_encode($wishlist))->get(
            route('removeFromWishlist', $product->id)
        );

        $response->assertCookie('wishlist', json_encode($expected));
    }
}
