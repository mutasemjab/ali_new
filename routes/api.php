<?php

use App\Http\Controllers\Api\Mobile\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student Mobile API — v1
|--------------------------------------------------------------------------
| Base URL : /api/v1/student/...
| Auth     : Laravel Sanctum — Bearer token
| Locale   : Accept-Language: ar|en  (default: ar)
|
| Response format:
|   { "status": true|false, "message": "...", "data": {...} }
|   Paginated: adds "pagination": { current_page, last_page, per_page, total }
|--------------------------------------------------------------------------
*/

Route::prefix('v1/')->middleware('api.locale')->group(function () {

    // ── Public store-browsing routes (customer mobile app, no auth) ────────
    Route::get('stores', [StoreController::class, 'index'])->name('api.stores.index');
    Route::get('stores/{store}', [StoreController::class, 'show'])->name('api.stores.show');
    Route::get('stores/{store}/privacy', [StoreController::class, 'privacy'])->name('api.stores.privacy');
    Route::post('stores/{store}/subscribe', [StoreController::class, 'subscribe'])->name('api.stores.subscribe');

    // ── Protected routes (require Bearer token) ────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

    });
});
