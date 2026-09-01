<?php

use App\Http\Controllers\Api\Mobile\ClientAuthController;
use App\Http\Controllers\Api\Mobile\ClientProfileController;
use App\Http\Controllers\Api\Mobile\StorefrontController;
use App\Http\Controllers\Api\Mobile\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mobile API — v1
|--------------------------------------------------------------------------
| Auth     : Laravel Sanctum — Bearer token
| Locale   : Accept-Language: ar|en  (default: ar)
|
| Response format:
|   { "status": true|false, "message": "...", "data": {...} }
|   Paginated: adds "pagination": { current_page, last_page, per_page, total }
|--------------------------------------------------------------------------
*/

Route::prefix('v1/')->middleware('api.locale')->group(function () {

    Route::get('privacy-policy', [StoreController::class, 'privacyPolicy'])->name('api.privacy-policy');

    // ── Store-picker app: pick-a-store, then browse (no auth) ──────────────
    Route::get('stores', [StoreController::class, 'index'])->name('api.stores.index');
    Route::get('stores/{store}', [StoreController::class, 'show'])->name('api.stores.show');
    Route::get('stores/{store}/privacy', [StoreController::class, 'privacy'])->name('api.stores.privacy');
    Route::get('stores/{store}/legal-document', [StoreController::class, 'legalDocument'])->name('api.stores.legal-document');
    Route::post('stores/{store}/subscribe', [StoreController::class, 'subscribe'])->name('api.stores.subscribe');
    Route::post('stores/{store}/verify-pin', [StoreController::class, 'verifyPin'])->name('api.stores.verify-pin');

    // ── Single-store client app ─────────────────────────────────────────────
    Route::prefix('stores/{store}')->group(function () {

        // Storefront browsing — public, works for guests too
        Route::get('home', [StoreController::class, 'home'])->name('api.stores.home');
        Route::get('categories', [StorefrontController::class, 'categories'])->name('api.stores.categories');
        Route::get('products', [StorefrontController::class, 'products'])->name('api.stores.products');
        Route::get('socials', [StorefrontController::class, 'socials'])->name('api.stores.socials');
        Route::get('qrs', [StorefrontController::class, 'qrs'])->name('api.stores.qrs');
        Route::get('weekly-ads', [StorefrontController::class, 'weeklyAds'])->name('api.stores.weekly-ads');
        Route::get('locations', [StorefrontController::class, 'locations'])->name('api.stores.locations');
        Route::get('coupons', [StorefrontController::class, 'coupons'])->name('api.stores.coupons');
        Route::get('rewards', [StorefrontController::class, 'rewards'])->name('api.stores.rewards');

        // Phone + OTP auth (Twilio) — no password
        Route::post('auth/register', [ClientAuthController::class, 'register'])->name('api.client.register');
        Route::post('auth/login', [ClientAuthController::class, 'login'])->name('api.client.login');
        Route::post('auth/resend-otp', [ClientAuthController::class, 'resendOtp'])->name('api.client.resend-otp');
        Route::post('auth/verify-otp', [ClientAuthController::class, 'verifyOtp'])->name('api.client.verify-otp');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('coupons/{coupon}/clip', [StorefrontController::class, 'clipCoupon'])->name('api.stores.coupons.clip');
        });
    });

    // ── Protected client routes (require Bearer token, store-independent) ──
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [ClientAuthController::class, 'logout'])->name('api.client.logout');
        Route::get('me', [ClientProfileController::class, 'show'])->name('api.client.me');
        Route::put('me', [ClientProfileController::class, 'update'])->name('api.client.me.update');
        Route::delete('me', [ClientProfileController::class, 'destroy'])->name('api.client.me.destroy');
        Route::get('me/coupons', [StorefrontController::class, 'myCoupons'])->name('api.client.me.coupons');
    });
});
