<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function addReview(ReviewRequest $request, $id): string
    {
        return app(ReviewService::class)->addReview($request->validated(), $id);
    }

    public function getProductReviews($id): View
    {
        $reviews = Review::where('product_id', $id)->with('user')->orderBy('created_at', 'desc')->paginate(4);
        return view('parts.reviews.reviews', [
            'reviews' => $reviews,
            'id'      => $id,
        ]);
    }

    public function deleteReview(int $id): string
    {
        return app(ReviewService::class)->deleteReview($id);
    }
}
