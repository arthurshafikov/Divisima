<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Ajax
Route::middleware(['ajax'])->group(function () {
    Route::get('/getReviews/{id}', [ReviewController::class, 'getProductReviews'])->name('getReviews');
    Route::post('/add-review/{id}', [ReviewController::class, 'addReview'])->name('add-review')->middleware('auth');
    Route::post('/delete-review/{id}', [ReviewController::class, 'deleteReview'])->name('delete-review')->middleware('auth');
    Route::post('/send/contactEmail', [MailController::class, 'contact'])->name('contactEmail');

    Route::get('/wishlist/add/{id}', [WishlistController::class, 'addToWishlist'])->name('addToWishlist');
    Route::get('/wishlist/remove/{id}', [WishlistController::class, 'removeFromWishlist'])->name('removeFromWishlist');

    Route::get('/getProducts/top-selling', [ProductController::class, 'getTopSellingProducts'])->name('getTopSellingProducts');

    Route::get('/add_to_cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
    Route::get('/cart/update_cart', [CartController::class, 'updateCart'])->name('updateCart');

    Route::post('/account/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('upload-avatar');
    Route::post('/account/change-profile', [ProfileController::class, 'changeProfile'])->name('change-profile');
});
