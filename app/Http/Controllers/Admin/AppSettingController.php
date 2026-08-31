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
}
