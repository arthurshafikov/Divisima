<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class)->name('home');

Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [ProductController::class, 'one'])->name('product');

Route::get('/blog', [PostController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PostController::class, 'one'])->name('post');

Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');

Route::prefix('cart')->group(function () {
    Route::get('', [CartController::class, 'cart'])->name('cart');
    Route::get('reset', [CartController::class, 'resetCart'])->name('resetCart');
    Route::post('', [PromocodeController::class, 'acceptPromocode'])->name('acceptPromocode');
    Route::delete('', [PromocodeController::class, 'removePromocode'])->name('removePromocode');
});

Route::prefix('checkout')->group(function () {
    Route::get('', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('', [OrderController::class, 'submit'])->name('submitOrder');

    Route::middleware('order.checkOwner')->group(function () {
        Route::get('thank-you/{orderId}', [OrderController::class, 'thank'])->name('thank-you');
        Route::get('order/{orderId}', [OrderController::class, 'order'])->name('order');
    });
});

Route::get('/category/{slug}', [CategoryController::class, 'category'])->name('category');

Route::get('/contact', [PagesController::class, 'contact'])->name('contact');

Route::get('/account', [ProfileController::class, 'account'])->middleware(['auth','verified'])->name('account');

Auth::routes(['verify' => true]);
