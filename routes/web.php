<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromocodeController as AdminPromocodeController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\ReviewController;
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
    Route::get('thank-you/{id}', [OrderController::class, 'thank'])->name('thank-you');
    Route::get('order/{id}', [OrderController::class, 'order'])->name('order');
});

Route::get('/category/{slug}', [CategoryController::class, 'category'])->name('category');

Route::get('/contact', [PagesController::class, 'contact'])->name('contact');

Route::get('/account', [ProfileController::class, 'account'])->middleware(['auth','verified'])->name('account');

Auth::routes(['verify' => true]);

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

// Admin Panel
$group = [
    'prefix'    => 'dashboard',
    'middleware' => 'admin',
];
Route::group($group, function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin');
    Route::get('/chart', [DashboardController::class, 'chart'])->name('chart');

    Route::prefix('products')->group(function () {
        Route::get('trash', [AdminProductController::class, 'trash'])->name('products.trash');
        Route::delete('{id}/forceDelete', [AdminProductController::class, 'forceDelete'])->name('products.forceDelete');
        Route::get('{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
    });

    Route::resource('products', AdminProductController::class)->names('products');
    Route::resource('posts', AdminPostController::class)->names('posts');
    Route::resource('slider', SlideController::class)->names('slider');
    Route::resource('categories', AdminCategoryController::class)->names('categories');
    Route::resource('promocodes', AdminPromocodeController::class)->names('promocodes');
    Route::resource('menus', MenuController::class)->names('menus');
    Route::resource('attributes', AttributeController::class)->names('attributes');
    Route::resource('orders', AdminOrderController::class)->except([
        'create', 'store', 'show',
    ])->names('orders');
    Route::resource('users', UserController::class)->except([
        'create', 'store','show',
    ])->names('users');

    Route::get('options', [OptionController::class, 'index'])->name('options');
    Route::post('options', [OptionController::class, 'save'])->name('options.update');

    Route::middleware(['ajax'])->group(function () {
        Route::get('/gallery/load', [MediaController::class, 'loadGallery'])->name('loadGallery');
        Route::get('/gallery/get', [MediaController::class, 'loadMediaImages'])->name('loadMediaImages');
        Route::delete('/gallery/delete', [MediaController::class, 'deleteImages'])->name('deleteImages');
        Route::post('/image/upload', [MediaController::class, 'uploadImage'])->name('upload-image');
    });
});
