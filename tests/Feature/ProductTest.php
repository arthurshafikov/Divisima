<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testShop()
    {
        $response = $this->get(route('shop'));
        $response->assertOk();
    }

    public function testShow(){
        $product = Product::factory()->create();

        $response = $this->get(route('product',$product->slug));

        $response->assertOk();
    }

    public function testCreate()
    {
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->get(route('products.create'));
        $response->assertOk();


        $product = Product::factory()->make();
        $response = $this->actingAs($admin)
                            ->post(route('products.store'),$product->toArray());

        // $response->dump();
        // $response->dumpSession();
        $response->assertStatus(302);
        $response->assertSessionHas('message');
        $this->assertDatabaseHas('products',[
            'name' => $product->name,
        ]);
    }

    public function testUpdate()
    {
        $admin = User::admin();

        $product = Product::inRandomOrder()->first();
        $response = $this->actingAs($admin)
                            ->get(route('products.edit',$product->id));
        $response->assertOk();

        $product->name = 'New Name';

        $response = $this->actingAs($admin)
                            ->patch(route('products.update',$product->id),$product->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $product = Product::factory()->create();
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->delete(route('products.destroy',$product->id));

        $response->assertSessionHas('message');
        $this->assertSoftDeleted($product);
    }

    public function testRestore()
    {
        $admin = User::admin();

        $product = Product::factory()->create();
        $product->delete();

        $response = $this->actingAs($admin)
                            ->get(route('products.trash'));

        $response->assertSee($product->id);


        $response = $this->actingAs($admin)
                            ->get(route('products.restore',$product->id));

        $response->assertSessionHas('message');

    }

    public function testForceDelete()
    {
        $admin = User::admin();
        
        $product = Product::factory()->create();
        $product->delete();

        $response = $this->actingAs($admin)
                            ->delete(route('products.forceDelete',$product->id));
        
        $response->assertSessionHas('message');
        $this->assertDatabaseMissing('products',[
            'name' => $product->name,
        ]);
    }
}
