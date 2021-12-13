<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function addReview(ReviewRequest $request, int $productId): string
    {
        return app(ReviewService::class)->addReview($request->validated(), $productId);
    }

    public function getProductReviews(int $productId): View
    {
        $reviews = Review::with('user')
            ->where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        return view('parts.reviews.reviews', [
            'reviews' => $reviews,
            'productId' => $productId,
        ]);
    }

    public function deleteReview(int $reviewId): string
    {
        return app(ReviewService::class)->deleteReview($reviewId);
    }
}
