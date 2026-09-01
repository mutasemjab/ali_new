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
            return view('public.ads.expired', ['ad' => $ad, 'reason' => 'expired']);
        }

        if ($ad->is_not_yet_started) {
            return view('public.ads.expired', ['ad' => $ad, 'reason' => 'not_yet_started']);
        }

        return view('public.ads.show', compact('ad'));
    }
}
