<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testShow()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('category', $category->slug));
        $response->assertOk();
    }

    public function testCreate()
    {
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->get(route('categories.create'));
        $response->assertOk();


        $category = Category::factory()->make();
        $response = $this->actingAs($admin)
                            ->post(route('categories.store'), $category->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::admin();

        $category = Category::inRandomOrder()->first();
        $response = $this->actingAs($admin)
                            ->get(route('categories.edit', $category->id));
        $response->assertOk();

        $category->name = 'New Name';

        $response = $this->actingAs($admin)
                            ->patch(route('categories.update', $category->id), $category->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $category = Category::factory()->create();
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->delete(route('categories.destroy', $category->id));

        $response->assertSessionHas('message');
    }

}
