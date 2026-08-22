<?php

use App\Http\Controllers\Store\AdController;
use App\Http\Controllers\Store\BannerController;
use App\Http\Controllers\Store\CategoryController;
use App\Http\Controllers\Store\ClientController;
use App\Http\Controllers\Store\CouponClientController;
use App\Http\Controllers\Store\CouponController;
use App\Http\Controllers\Store\DashboardController;
use App\Http\Controllers\Store\FeedbackController;
use App\Http\Controllers\Store\LocationController;
use App\Http\Controllers\Store\LoginController;
use App\Http\Controllers\Store\MessageController;
use App\Http\Controllers\Store\NotificationController;
use App\Http\Controllers\Store\PageSettingsController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\QrController;
use App\Http\Controllers\Store\SocialController;
use App\Http\Controllers\Store\WeeklyAdController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::group(['prefix' => 'store', 'middleware' => ['auth:store', 'tenant', 'store.active']], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('store.dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('store.logout');

        Route::get('/account/edit/{id}', [LoginController::class, 'editlogin'])->name('store.login.edit');
        Route::post('/account/update/{id}', [LoginController::class, 'updatelogin'])->name('store.login.update');

        Route::resource('clients', ClientController::class, ['as' => 'store'])->except(['show']);
        Route::resource('messages', MessageController::class, ['as' => 'store'])->only(['index', 'create', 'store', 'show', 'destroy']);

        Route::resource('categories', CategoryController::class, ['as' => 'store'])->except(['show']);
        Route::post('categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('store.categories.toggle');

        Route::resource('products', ProductController::class, ['as' => 'store'])->except(['show']);

        Route::resource('ads', AdController::class, ['as' => 'store'])->only(['index', 'create', 'store', 'destroy']);

        Route::resource('coupons', CouponController::class, ['as' => 'store'])->except(['show']);

        Route::resource('banners', BannerController::class, ['as' => 'store'])->only(['index', 'create', 'store', 'destroy']);

        Route::resource('weekly-ads', WeeklyAdController::class, ['as' => 'store'])->except(['show']);

        Route::resource('socials', SocialController::class, ['as' => 'store'])->except(['show']);

        Route::resource('locations', LocationController::class, ['as' => 'store'])->except(['show']);

        Route::resource('qrs', QrController::class, ['as' => 'store'])->only(['index', 'create', 'store', 'destroy']);

        Route::resource('coupon-clients', CouponClientController::class, ['as' => 'store'])->only(['index', 'destroy']);

        Route::resource('notifications', NotificationController::class, ['as' => 'store'])->only(['index', 'create', 'store', 'destroy']);

        Route::get('feedback', [FeedbackController::class, 'index'])->name('store.feedback.index');
        Route::delete('feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('store.feedback.destroy');

        Route::get('pages', [PageSettingsController::class, 'edit'])->name('store.pages.edit');
        Route::put('pages', [PageSettingsController::class, 'update'])->name('store.pages.update');
    });
});

Route::group(['prefix' => 'store', 'middleware' => 'guest:store'], function () {
    Route::get('login', [LoginController::class, 'show_login_view'])->name('store.showlogin');
    Route::post('login', [LoginController::class, 'login'])->name('store.login');
});
