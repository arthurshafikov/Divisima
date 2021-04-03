<?php

namespace Tests\Feature;

use App\Models\Promocode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PromocodeTest extends TestCase
{

    public function testAcceptPromocode()
    {
        $promocode = Promocode::first();

        $response = $this->post(route('acceptPromocode'),[
                'promocode' => $promocode->promocode
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('msg');
        
        $response = $this->get(route('cart'));

        $response->assertSee('Promocode was applied!');
        $response->assertSessionHas('promocode');

    }
    public function testRemovePromocode()
    {
        $promocode = Promocode::first();

        $response = $this->withSession(['promocode' => $promocode->promocode])->delete(route('removePromocode'));

        $response->assertRedirect();
        $response->assertSessionHas('msg');
        $response->assertSessionMissing('promocode');
    }

    public function testCreate()
    {
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->get(route('promocodes.create'));
        $response->assertOk();


        $promocode = Promocode::factory()->make();
        $response = $this->actingAs($admin)
                            ->post(route('promocodes.store'),$promocode->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::admin();

        $promocode = Promocode::inRandomOrder()->first();
        $response = $this->actingAs($admin)
                            ->get(route('promocodes.edit',$promocode->id));
        $response->assertOk();

        $promocode->promocode = 'New title';

        $response = $this->actingAs($admin)
                            ->patch(route('promocodes.update',$promocode->id),$promocode->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $promocode = Promocode::factory()->create();
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->delete(route('promocodes.destroy',$promocode->id));

        $response->assertSessionHas('message');
    }
}
