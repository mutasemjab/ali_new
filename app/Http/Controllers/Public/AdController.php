<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Ad;

class AdController extends Controller
{
    public function show(string $token)
    {
        $ad = Ad::with(['products', 'store.socials', 'images'])->where('token', $token)->firstOrFail();

        if ($ad->is_expired) {
            return view('public.ads.expired', compact('ad'));
        }

        return view('public.ads.show', compact('ad'));
    }
}
