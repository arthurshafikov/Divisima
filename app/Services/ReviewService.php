<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function addReview(array $params, int $productId): string
    {
        $userAlreadyHasReview = Review::where([
            ['user_id', Auth::id()],
            ['product_id', $productId],
        ])->exists();

        if ($userAlreadyHasReview) {
            return __('review.have');
        }

        $params['product_id'] = $productId;
        $params['user_id'] =  Auth::id();
        Review::create($params);

        return '1';
    }

    public function deleteReview(int $reviewId): string
    {
        $review = Review::findOrFail($reviewId);
        if ($review->user->id !== Auth::id()) {
            return __('review.cant_delete');
        }

        $review->delete();

        return '1';
    }
}
