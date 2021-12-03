<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Promocode;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PromocodeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $promocode = Promocode::factory()->make();

        $response = $this->actingAs($admin)
            ->post(route('promocodes.store'), $promocode->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $promocode = Promocode::factory()->create();
        $promocode->promocode = 'New title';

        $response = $this->actingAs($admin)
            ->patch(route('promocodes.update', $promocode->id), $promocode->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $promocode = Promocode::factory()->create();
        $admin = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($admin)
            ->delete(route('promocodes.destroy', $promocode->id));

        $response->assertSessionHas('message');
    }
}
