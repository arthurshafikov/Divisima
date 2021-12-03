<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SlideControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $slide = Slide::factory()->make();

        $response = $this->actingAs($admin)
            ->post(route('slider.store'), $slide->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $slide = Slide::factory()->create();
        $slide->title = 'New Name';

        $response = $this->actingAs($admin)
            ->patch(route('slider.update', $slide->id), $slide->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $slide = Slide::factory()->create();

        $response = $this->actingAs($admin)
            ->delete(route('slider.destroy', $slide->id));

        $response->assertSessionHas('message');
    }
}
