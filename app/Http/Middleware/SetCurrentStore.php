<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCurrentStore
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('store')->check()) {
            app()->instance('tenant', auth()->guard('store')->user());
        }

        return $next($request);
    }
}
