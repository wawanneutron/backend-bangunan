<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});
/*
 route for admin 
 */
//  group rout with prefix
Route::prefix('admin')
    ->group(function () {
        // group with middleware "auth"
        Route::group(['middleware' => 'auth'], function () {

            Route::resource('/category', CategoryController::class, ['as' => 'admin']);
            Route::resource('/product', ProductController::class, ['as' => 'admin']);
            Route::resource('/gallery', GalleryController::class, ['as' => 'admin']);
            Route::resource('/slider', SliderController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);
            Route::resource('/user', UserController::class, ['as' => 'admin']);
            Route::resource('/order', OrderController::class, ['except' => ['destroy'], 'as' => 'admin']);

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('admin.dashboard.index');

            Route::get('/customer', [CustomerController::class, 'index'])
                ->name('admin.customer.index');
            Route::get('/profile', [ProfileController::class, 'index'])
                ->name('admin.profile.index');

            // laporan
            Route::get('/report-product', [ReportController::class, 'cetak_pdf_product'])
                ->name('admin.cetak.product');
            Route::get('/report-orders', [ReportController::class, 'cetak_pdf_orders'])
                ->name('admin.cetak.orders');
            Route::get('/report-detail-order/{id}', [ReportController::class, 'cetak_detail_order'])
                ->name('admin.cetak.detail.order');
            Route::get('report-data-customers', [ReportController::class, 'cetak_data_customers'])
                ->name('admin.cetak.data.customers');
        });
    });
