<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    public function testGetReviews()
    {
        $product = Product::whereHas('reviews')->first();

        $response = $this->get(route('getReviews', $product->id));
        
        $response->assertStatus(200);
        $response->assertSee('Load more');
    }
    
    public function testAddReview()
    {
        $product = Product::factory()->create();
        $user = User::first();
        $review = Review::factory()->make([
            'user_id' => $user->id,
        ]);

        // redirect because user is not authenticated
        $response = $this->post(route('add-review', $product->id), $review->toArray());

        $response->assertStatus(302);


        $response = $this->actingAs($user)
                            ->post(route('add-review', $product->id), $review->toArray());
        
        $response->assertSee('1');

        $response = $this->actingAs($user)
                            ->post(route('add-review', $product->id), $review->toArray());
        
        $response->assertSee('You already have a review here');
    }

    public function testRemoveReview()
    {
        $review = Review::factory()->create();
        $user = $review->user;

        $response = $this->actingAs($user)
                            ->post(route('delete-review', $review->id));

        $response->assertSee('1');
        $response->assertOk();
    }

    public function testDeleteForeignReview()
    {
        $review = Review::factory()->create();
        $random_user = User::factory()->create();

        $response = $this->post(route('delete-review', $review->id));

        $response->assertRedirect();

        $response = $this->actingAs($random_user)
                            ->post(route('delete-review', $review->id));

        $response->assertSee('You are not allowed to delete this review!');
    }
}
