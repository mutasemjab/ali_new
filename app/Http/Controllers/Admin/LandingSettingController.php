<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    public function edit()
    {
        $setting = LandingSetting::current();

        return view('admin.landing-settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'nullable|string|max:200',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_image_home' => 'nullable|image|max:4096',
            'hero_image_plans' => 'nullable|image|max:4096',
            'monthly_fee_amount' => 'nullable|string|max:50',
            'monthly_fee_label' => 'nullable|string|max:100',
            'redeem_banner_text' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:50',
            'cta_url' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:200',
            'about_body' => 'nullable|string',
            'contact_email' => 'nullable|email|max:200',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'hero_title', 'hero_subtitle', 'monthly_fee_amount', 'monthly_fee_label',
            'redeem_banner_text', 'cta_text', 'cta_url', 'about_title', 'about_body',
            'contact_email', 'contact_phone', 'contact_address',
        ]);

        $setting = LandingSetting::current();

        if ($request->hasFile('hero_image_home')) {
            $data['hero_image_home'] = 'assets/uploads/landing/' . uploadImage('assets/uploads/landing', $request->file('hero_image_home'));
        }

        if ($request->hasFile('hero_image_plans')) {
            $data['hero_image_plans'] = 'assets/uploads/landing/' . uploadImage('assets/uploads/landing', $request->file('hero_image_plans'));
        }

        $setting->update($data);

        return redirect()->route('admin.landing-settings.edit')->with('success', 'Landing page settings updated successfully');
    }
}
