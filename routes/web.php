<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\AdController;
use App\Http\Controllers\Public\FeedbackController;
use App\Http\Controllers\Public\LandingController;
use App\Http\Controllers\Public\StoreController;
use App\Http\Controllers\Public\WeeklyAdController;
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
});

// ── Ad / weekly-ad SMS links — always English, no /en/ locale prefix ──
Route::get('ads/{token}', [AdController::class, 'show'])->name('public.ads.show');
Route::get('weekly-ads/{token}', [WeeklyAdController::class, 'show'])->name('public.weekly-ads.show');

// ── FlyerAll marketing site — always English, no /en/ locale prefix ──
Route::get('/', [LandingController::class, 'home'])->name('landing.home');
Route::get('features', [LandingController::class, 'features'])->name('landing.features');
Route::get('plans', [LandingController::class, 'plans'])->name('landing.plans');
Route::get('how-it-works', [LandingController::class, 'howItWorks'])->name('landing.how-it-works');
Route::get('about', [LandingController::class, 'about'])->name('landing.about');
Route::get('contact', [LandingController::class, 'contact'])->name('landing.contact');
