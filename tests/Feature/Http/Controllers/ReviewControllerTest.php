<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetReviews()
    {
        $product = Product::factory()->hasReviews()->create();

        $response = $this->get(route('getReviews', $product->id));

        $response->assertStatus(200);
        $response->assertSee('Load more');
    }

    public function testUnathorizedAddReview()
    {
        $product = Product::factory()->create();
        $review = Review::factory()->make();

        $response = $this->post(route('add-review', $product->id), $review->toArray());

        $response->assertStatus(302);
    }

    public function testAddReviewAndDuplicateIt()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $review = Review::factory()->make([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('add-review', $product->id), $review->toArray());
        $response2 = $this->actingAs($user)
            ->post(route('add-review', $product->id), $review->toArray());

        $response->assertSee('1');
        $response2->assertSee('You already have a review here');
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
        $randomUser = User::factory()->create();

        $response = $this->post(route('delete-review', $review->id));
        $response2 = $this->actingAs($randomUser)->post(route('delete-review', $review->id));

        $response->assertRedirect();
        $response2->assertSee('You are not allowed to delete this review!');
    }
}
