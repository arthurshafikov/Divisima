<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

$group = [
    'prefix'    => 'dashboard',
    'middleware' => 'admin',
];
Route::group($group, function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin');
    Route::get('/chart', [DashboardController::class, 'chart'])->name('chart');

    Route::prefix('products')->group(function () {
        Route::get('trash', [ProductController::class, 'trash'])->name('products.trash');
        Route::delete('{id}/forceDelete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
        Route::get('{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    });

    Route::resource('products', ProductController::class)->names('products');
    Route::resource('posts', PostController::class)->names('posts');
    Route::resource('slider', SlideController::class)->names('slider');
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('promocodes', PromocodeController::class)->names('promocodes');
    Route::resource('menus', MenuController::class)->names('menus');
    Route::resource('attributes', AttributeController::class)->names('attributes');
    Route::resource('orders', OrderController::class)->except([
        'create', 'store', 'show',
    ])->names('orders');
    Route::resource('users', UserController::class)->except([
        'create', 'store','show',
    ])->names('users');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings', [SettingsController::class, 'save'])->name('settings.update');

    Route::middleware(['ajax'])->group(function () {
        Route::get('/gallery/load', [MediaController::class, 'loadGallery'])->name('loadGallery');
        Route::get('/gallery/get', [MediaController::class, 'loadMediaImages'])->name('loadMediaImages');
        Route::delete('/gallery/delete', [MediaController::class, 'deleteImages'])->name('deleteImages');
        Route::post('/image/upload', [MediaController::class, 'uploadImage'])->name('upload-image');
    });
});
