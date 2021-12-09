<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testShow()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('post', $post->slug));

        $response->assertOk();
    }

    public function testStore()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $post = Post::factory()->make();

        $response = $this->actingAs($admin)
            ->post(route('posts.store'), $post->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::factory()->create()->assignRole(Role::ADMIN);
        $post = Post::factory()->create();
        $post->name = 'New title';

        $response = $this->actingAs($admin)
            ->patch(route('posts.update', $post->id), $post->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $post = Post::factory()->create();
        $admin = User::factory()->create()->assignRole(Role::ADMIN);

        $response = $this->actingAs($admin)
            ->delete(route('posts.destroy', $post->id));

        $response->assertSessionHas('message');
    }
}
