<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        $admin = User::admin();
        $product = Product::factory()->make();

        $response = $this->actingAs($admin)
            ->post(route('products.store'), $product->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
        ]);
    }

    public function testUpdate()
    {
        $admin = User::admin();
        $product = Product::factory()->create();
        $product->name = 'New Name';

        $response = $this->actingAs($admin)
            ->patch(route('products.update', $product->id), $product->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $admin = User::admin();
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)
            ->delete(route('products.destroy', $product->id));

        $response->assertSessionHas('message');
        $this->assertSoftDeleted($product);
    }

    public function testTrash()
    {
        $admin = User::admin();
        $product = Product::factory()->create();
        $product->delete();

        $response = $this->actingAs($admin)
            ->get(route('products.trash'));

        $response->assertSee($product->id);
    }

    public function testRestore()
    {
        $admin = User::admin();
        $product = Product::factory()->create();
        $product->delete();

        $response = $this->actingAs($admin)
            ->get(route('products.restore', $product->id));

        $response->assertSessionHas('message');
    }

    public function testForceDelete()
    {
        $admin = User::admin();
        $product = Product::factory()->create();
        $product->delete();

        $response = $this->actingAs($admin)
            ->delete(route('products.forceDelete', $product->id));
        
        $response->assertSessionHas('message');
        $this->assertDatabaseMissing('products', [
            'name' => $product->name,
        ]);
    }
}
