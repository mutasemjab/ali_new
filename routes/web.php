<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\AdController;
use App\Http\Controllers\Public\FeedbackController;
use App\Http\Controllers\Public\LandingController;
use App\Http\Controllers\Public\StoreController;
use App\Http\Controllers\Public\StoreSiteController;
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

    // Clean, id-less links for the current subdomain's store (resolved from the Host
    // header). Deliberately NOT under store/legal/... — that URI is already taken by the
    // authenticated store-admin edit pages in routes/store.php (same GET verb, would
    // silently shadow one or the other).
    Route::get('store-legal/privacy', [StoreController::class, 'subdomainPrivacy'])->name('public.store.legal.privacy');
    Route::get('store-legal/terms', [StoreController::class, 'subdomainTerms'])->name('public.store.legal.terms');
    Route::get('store-legal/anti-spam', [StoreController::class, 'subdomainAntiSpam'])->name('public.store.legal.anti-spam');

    Route::get('store/{store}/privacy', [StoreController::class, 'privacy'])->name('public.stores.privacy');
    Route::get('store/{store}/terms', [StoreController::class, 'termsOfService'])->name('public.stores.terms');
    Route::get('store/{store}/anti-spam', [StoreController::class, 'antiSpamPolicy'])->name('public.stores.anti-spam');
    Route::get('store/{store}/feedback', [FeedbackController::class, 'create'])->name('public.stores.feedback.create');
    Route::post('store/{store}/feedback', [FeedbackController::class, 'store'])->name('public.stores.feedback.store');
});

// ── Ad / weekly-ad SMS links — always English, no /en/ locale prefix ──
Route::get('ads/{token}', [AdController::class, 'show'])->name('public.ads.show');
Route::get('weekly-ads/{token}', [WeeklyAdController::class, 'show'])->name('public.weekly-ads.show');

// ── Per-store "website" — same landing look & feel, but this store's own data only.
// Matches just these 3 paths, and only on a store's own subdomain (resolved from the
// Host header); any other host — including the bare root domain — falls through to the
// marketing site below. Registered first: a route with no domain() matches ANY host, so
// it must come after this group or it would win the match before this one is ever tried.
Route::domain('{subdomain}.' . parse_url(config('app.url'), PHP_URL_HOST))->group(function () {
    Route::get('/', [StoreSiteController::class, 'home'])->name('store-site.home');
    Route::get('how-it-works', [StoreSiteController::class, 'howItWorks'])->name('store-site.how-it-works');
    Route::get('about', [StoreSiteController::class, 'about'])->name('store-site.about');
    Route::get('contact', [StoreSiteController::class, 'contact'])->name('store-site.contact');
    Route::post('contact', [StoreSiteController::class, 'storeFeedback'])->name('store-site.contact.store');
});

// ── FlyerAll marketing site — always English, no /en/ locale prefix ──
Route::get('/', [LandingController::class, 'home'])->name('landing.home');
Route::get('features', [LandingController::class, 'features'])->name('landing.features');
Route::get('plans', [LandingController::class, 'plans'])->name('landing.plans');
Route::post('plans/inquire', [LandingController::class, 'storePlanInquiry'])->name('landing.plans.inquire');
Route::get('how-it-works', [LandingController::class, 'howItWorks'])->name('landing.how-it-works');
Route::get('about', [LandingController::class, 'about'])->name('landing.about');
Route::get('contact', [LandingController::class, 'contact'])->name('landing.contact');
Route::post('contact', [LandingController::class, 'storeContactMessage'])->name('landing.contact.store');
Route::get('privacy-policy', [LandingController::class, 'privacyPolicy'])->name('landing.privacy-policy');
Route::get('terms-of-service', [LandingController::class, 'termsOfService'])->name('landing.terms-of-service');
Route::get('anti-spam-policy', [LandingController::class, 'antiSpamPolicy'])->name('landing.anti-spam-policy');
