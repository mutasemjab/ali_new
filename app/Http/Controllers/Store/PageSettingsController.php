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
            'privacy_policy' => 'nullable|string',
            'facebook_link' => 'nullable|url|max:255',
        ]);

        auth('store')->user()->update([
            'privacy_policy' => $request->privacy_policy,
            'facebook_link' => $request->facebook_link,
        ]);

        return redirect()->route('store.pages.edit')->with('success', 'Changes saved successfully');
    }
}
