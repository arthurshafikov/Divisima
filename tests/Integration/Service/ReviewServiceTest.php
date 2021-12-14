<?php

namespace Tests\Integration\Service;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\ReviewService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ReviewServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddReview()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        Auth::login($user);
        $params = [
            'text' => 'someReviewText',
            'rating' => '5',
        ];

        $result = app(ReviewService::class)->addReview($params, $product->id);

        $this->assertEquals('1', $result);
        $this->assertDatabaseHas(Review::class, [
            'product_id' => $product->id,
            'text' => 'someReviewText',
            'rating' => '5',
        ]);
    }

    public function testDeleteReview()
    {
        $product = Product::factory()->hasReviews(1)->create();
        $review = $product->reviews->first();
        $user = $review->user;
        Auth::login($user);

        $result = app(ReviewService::class)->deleteReview($review->id);

        $this->assertEquals('1', $result);
        $this->assertDatabaseMissing(Review::class, [
            'product_id' => $product->id,
            'text' => $review->text,
            'rating' => $review->rating,
        ]);
    }
}
