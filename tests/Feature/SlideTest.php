<?php

namespace Tests\Feature;

use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SlideTest extends TestCase
{

    public function testCreate()
    {
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->get(route('slider.create'));
        $response->assertOk();


        $slide = Slide::factory()->make();
        $response = $this->actingAs($admin)
                            ->post(route('slider.store'), $slide->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::admin();

        $slide = Slide::inRandomOrder()->first();
        $response = $this->actingAs($admin)
                            ->get(route('slider.edit', $slide->id));
        $response->assertOk();

        $slide->title = 'New Name';

        $response = $this->actingAs($admin)
                            ->patch(route('slider.update', $slide->id), $slide->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $slide = Slide::factory()->create();
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->delete(route('slider.destroy', $slide->id));

        $response->assertSessionHas('message');
    }
}
