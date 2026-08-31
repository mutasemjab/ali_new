<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WeeklyAd;

class WeeklyAdController extends Controller
{
    public function show(string $token)
    {
        $weeklyAd = WeeklyAd::with('store.socials')->where('token', $token)->firstOrFail();

        return view('public.weekly-ads.show', compact('weeklyAd'));
    }
}
