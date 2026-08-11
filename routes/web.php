<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\AdController;
use App\Http\Controllers\Public\FeedbackController;
use App\Http\Controllers\Public\StoreController;
use App\Http\Controllers\StudentAuthController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'website.mode'],
], function () {


});

// ── Public store pages (no auth — reached via SMS/ad links) ────────────
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {

    Route::get('store/{store}/privacy', [StoreController::class, 'privacy'])->name('public.stores.privacy');
    Route::get('store/{store}/feedback', [FeedbackController::class, 'create'])->name('public.stores.feedback.create');
    Route::post('store/{store}/feedback', [FeedbackController::class, 'store'])->name('public.stores.feedback.store');

    Route::get('ads/{token}', [AdController::class, 'show'])->name('public.ads.show');
});
