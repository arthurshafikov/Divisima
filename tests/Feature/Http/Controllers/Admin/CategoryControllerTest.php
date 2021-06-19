<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        $admin = User::admin();
        $category = Category::factory()->make();

        $response = $this->actingAs($admin)
            ->post(route('categories.store'), $category->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::admin();
        $category = Category::factory()->create();
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
