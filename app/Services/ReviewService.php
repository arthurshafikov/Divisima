<?php

namespace App\Services;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function addReview(array $validated, int $id): string
    {
        $validated['product_id'] = $id;
        $validated['user_id'] =  Auth::id();

        $userAlreadyHasReview = Review::where([
            ['user_id', Auth::id()],
            ['product_id', $id],
        ])->exists();

        if ($userAlreadyHasReview) {
            return 'You already have a review here';
        }

        Review::create($validated);

        return '1';
    }

    public function deleteReview(int $id): string
    {
        $review = Review::findOrFail($id);
        if ($review->user->id !== Auth::id()) {
            return 'You are not allowed to delete this review!';
        }

        $review->delete();

        return '1';
    }
}
