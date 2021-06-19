<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController')->name('home');

Route::get('/product/{slug}', 'ProductController@one')->name('product');

Route::get('/blog', 'PostController@blog')->name('blog');
Route::get('/blog/{slug}', 'PostController@one')->name('post');

Route::get('/shop', 'ProductController@shop')->name('shop');

Route::get('/wishlist', 'WishlistController@wishlist')->name('wishlist');

Route::get('/cart', 'CartController@cart')->name('cart');

Route::get('/cart/reset', 'CartController@resetCart')->name('resetCart');
Route::post('/cart', 'PromocodeController@acceptPromocode')->name('acceptPromocode');
Route::delete('/cart', 'PromocodeController@removePromocode')->name('removePromocode');

Route::get('/checkout', 'OrderController@checkout')->name('checkout');
Route::post('/checkout', 'OrderController@submit')->name('submitOrder');
Route::get('/checkout/thank-you/{id}', 'OrderController@thank')->name('thank-you');
Route::get('/checkout/order/{id}', 'OrderController@order')->name('order');

Route::get('/category/{slug}', 'CategoryController@category')->name('category');

Route::get('/contact', 'PagesController@contact')->name('contact');


Route::get('/account', 'ProfileController@account')->middleware(['auth','verified'])->name('account');

Auth::routes(['verify' => true]);

// Ajax
Route::middleware(['ajax'])->group(function () {
    Route::get('/getReviews/{id}', 'ReviewController@getProductReviews')->name('getReviews');
    Route::post('/add-review/{id}', 'ReviewController@addReview')->name('add-review')->middleware('auth');
    Route::post('/delete-review/{id}', 'ReviewController@deleteReview')->name('delete-review')->middleware('auth');
    Route::post('/send/contactEmail', 'MailController@contact')->name('contactEmail');

    Route::get('/wishlist/add/{id}', 'WishlistController@addToWishlist')->name('addToWishlist');
    Route::get('/wishlist/remove/{id}', 'WishlistController@removeFromWishlist')->name('removeFromWishlist');

    Route::get('/getProducts/top-selling', 'ProductController@getTopSellingProducts')->name('getTopSellingProducts');

    Route::get('/add_to_cart/{id}', 'CartController@addToCart')->name('addToCart');
    Route::get('/cart/update_cart', 'CartController@updateCart')->name('updateCart');

    Route::post('/account/upload-avatar', 'ProfileController@uploadAvatar')->name('upload-avatar');
    Route::post('/account/change-profile', 'ProfileController@changeProfile')->name('change-profile');
});



// Admin Panel
$group = [
    'namespace' => 'Admin',
    'prefix'    => 'dashboard',
    'middleware' => 'admin',
];
Route::group($group, function () {

    Route::get('/', 'DashboardController@index')->name('admin');
    Route::get('/chart', 'DashboardController@chart')->name('chart');

    Route::get('products/trash', 'ProductController@trash')->name('products.trash');
    Route::delete('products/{id}/forceDelete', 'ProductController@forceDelete')->name('products.forceDelete');
    Route::get('products/{id}/restore', 'ProductController@restore')->name('products.restore');

    Route::resource('products', 'ProductController')->names('products');


    Route::resource('posts', 'PostController')->names('posts');
    Route::resource('slider', 'SlideController')->names('slider');
    Route::resource('categories', 'CategoryController')->names('categories');
    Route::resource('promocodes', 'PromocodeController')->names('promocodes');
    Route::resource('menus', 'MenuController')->names('menus');
    Route::resource('attributes', 'AttributeController')->names('attributes');


    Route::resource('orders', 'OrderController')->except([
        'create', 'store','show',
    ])->names('orders');
    Route::resource('users', 'UserController')->except([
        'create', 'store','show',
    ])->names('users');


    Route::get('options', 'OptionController@index')->name('options');
    Route::post('options', 'OptionController@save')->name('options.update');


    Route::middleware(['ajax'])->group(function () {
        Route::get('/gallery/load', 'MediaController@loadGallery')->name('loadGallery');
        Route::get('/gallery/get', 'MediaController@loadMediaImages')->name('loadMediaImages');
        Route::delete('/gallery/delete', 'MediaController@deleteImages')->name('deleteImages');
        Route::post('/image/upload', 'MediaController@uploadImage')->name('upload-image');
    });
});
