<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageSettingsController extends Controller
{
    public function edit()
    {
        $store = auth('store')->user();

        return view('store.pages.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'facebook_link' => 'nullable|url|max:255',
        ]);

        auth('store')->user()->update([
            'facebook_link' => $request->facebook_link,
            'show_in_store_deals' => $request->boolean('show_in_store_deals'),
            'show_social' => $request->boolean('show_social'),
            'show_qr' => $request->boolean('show_qr'),
            'show_weekly_ads' => $request->boolean('show_weekly_ads'),
            'show_coupons' => $request->boolean('show_coupons'),
            'show_location' => $request->boolean('show_location'),
            'show_rewards' => $request->boolean('show_rewards'),
        ]);

        return redirect()->route('store.pages.edit')->with('success', 'Changes saved successfully');
    }
}
