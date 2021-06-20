<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function addReview(ReviewRequest $request, $id): string
    {
        $data = $request->validated();
        $data['product_id'] = $id;
        $data['user_id'] =  Auth::id();

        $reviews = Review::where([
            ['user_id', Auth::id()],
            ['product_id', $id],
        ])->get();

        if ($reviews->isEmpty()) {
            Review::create($data);
            return '1';
        }
        return 'You already have a review here';
    }

    public function getProductReviews($id)
    {
        $reviews = Review::where('product_id', $id)->with('user')->orderBy('created_at', 'desc')->paginate(4);
        return view('parts.reviews.reviews', [
            'reviews' => $reviews,
            'id'      => $id,
        ]);
    }

    public function deleteReview($id): string
    {
        $review = Review::findOrFail($id);
        if ($review->user->id === Auth::id()) {
            $review->delete();
            return '1';
        }
        return 'You are not allowed to delete this review!';
    }
}
