<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/* 
    Route API Auth
*/

Route::post('/login', [AuthController::class, 'login'])
    ->name('api.customer.login');
Route::post('/register', [AuthController::class, 'register'])
    ->name('api.customer.register');
Route::get('/user', [AuthController::class, 'getUser'])
    ->name('api.customer.user');

// routes order
Route::get('/order', [OrderController::class, 'index'])
    ->name('api.order.index');
Route::get('/order/{snap_token?}', [OrderController::class, 'show'])
    ->name('api.order.show');

// routs category
Route::get('/categories-all', [CategoryController::class, 'index'])
    ->name('api.category.all');
Route::get('/category-show/{slug?}', [CategoryController::class, 'show'])
    ->name('api.category.show');
Route::get('/categories-home', [CategoryController::class, 'categoryHome'])
    ->name('api.category.index');

// routs products
Route::get('/products', [ProductController::class, 'productAll'])
    ->name('api.product.index');
Route::get('/products-home', [ProductController::class, 'productHome'])
    ->name('api.product.home');
Route::get('/products-terlaris', [ProductController::class, 'terlaris'])
    ->name('api.product.terlaris');
Route::get('/product/{slug?}', [ProductController::class, 'show'])
    ->name('api.product.show');
Route::get('/product/search/{keyword}', [ProductController::class, 'search'])
    ->name('api.product.search');

// routs Cart
Route::get('/cart', [CartController::class, 'index'])
    ->name('api.cart.index');
Route::post('/cart', [CartController::class, 'addToCart'])
    ->name('api.cart.addToCart');
Route::get('/cart/total', [CartController::class, 'cartTotalPrice'])
    ->name('api.cart.total');
Route::get('/cart/before-discount', [CartController::class, 'beforeDiscount'])
    ->name('api.cart.beforeDiscount');
Route::get('/cart/total-weight', [CartController::class, 'cartTotalWeight'])
    ->name('api.cart.weight');
Route::post('/cart/remove', [CartController::class, 'removeCart'])
    ->name('api.cart.remove');
Route::post('/cart/remove-all', [CartController::class, 'removeAllCart'])
    ->name('api.cart.removeAll');

// route slider
Route::get('/sliders', [SliderController::class, 'index'])->name('data.slider');

// routes Region Distrik
Route::get('/origin/provinces', [RegionController::class, 'getProvinces'])
    ->name('customer.origin.getProvinces');
Route::get('/origin/cities', [RegionController::class, 'getCities'])
    ->name('customer.origin.getCities');

// routs checkout (midtrans)
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/notification-handler', [CheckoutController::class, 'notificationHandler'])->name('checkout.notificationHandler');


// routes review / star rating
Route::post('/review', [ReviewController::class, 'addReview'])->name('review.customer');
Route::post('/reviewcek', [ReviewController::class, 'cekReview'])->name('review.cekReview');
