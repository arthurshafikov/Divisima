<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function testBlog()
    {
        $response = $this->get(route('blog'));
        $response->assertOk();
    }

    public function testShow()
    {
        $post = Post::factory()->create();
        $response = $this->get(route('post',$post->slug));
        $response->assertOk();
    }

    public function testCreate()
    {
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->get(route('posts.create'));
        $response->assertOk();


        $post = Post::factory()->make();
        $response = $this->actingAs($admin)
                            ->post(route('posts.store'),$post->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testUpdate()
    {
        $admin = User::admin();

        $post = Post::inRandomOrder()->first();
        $response = $this->actingAs($admin)
                            ->get(route('posts.edit',$post->id));
        $response->assertOk();

        $post->title = 'New title';

        $response = $this->actingAs($admin)
                            ->patch(route('posts.update',$post->id),$post->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $post = Post::factory()->create();
        $admin = User::admin();

        $response = $this->actingAs($admin)
                            ->delete(route('posts.destroy',$post->id));

        $response->assertSessionHas('message');
    }

}
