<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function editPrivacy()
    {
        $setting = AppSetting::current();

        return view('admin.settings.privacy', compact('setting'));
    }

    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'privacy_policy' => 'nullable|string',
        ]);

        AppSetting::current()->update([
            'privacy_policy' => $request->privacy_policy,
        ]);

        return redirect()->route('admin.settings.privacy.edit')->with('success', 'Privacy policy updated successfully');
    }

    public function editTerms()
    {
        $setting = AppSetting::current();

        return view('admin.settings.terms', compact('setting'));
    }

    public function updateTerms(Request $request)
    {
        $request->validate([
            'terms_of_service' => 'nullable|string',
        ]);

        AppSetting::current()->update([
            'terms_of_service' => $request->terms_of_service,
        ]);

        return redirect()->route('admin.settings.terms.edit')->with('success', 'Terms of service updated successfully');
    }

    public function editAntiSpam()
    {
        $setting = AppSetting::current();

        return view('admin.settings.anti-spam', compact('setting'));
    }

    public function updateAntiSpam(Request $request)
    {
        $request->validate([
            'anti_spam_policy' => 'nullable|string',
        ]);

        AppSetting::current()->update([
            'anti_spam_policy' => $request->anti_spam_policy,
        ]);

        return redirect()->route('admin.settings.anti-spam.edit')->with('success', 'Anti-spam policy updated successfully');
    }
}
