<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStoreIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $store = auth()->guard('store')->user();

        if ($store && ! $store->isActive()) {
            auth()->guard('store')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('store.showlogin')->with('error', 'This store account has been suspended. Please contact support.');
        }

        return $next($request);
    }
}
