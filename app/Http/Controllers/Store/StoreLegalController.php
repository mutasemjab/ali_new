<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreLegalController extends Controller
{
    public function editPrivacy()
    {
        $store = auth('store')->user();

        return view('store.legal.privacy', compact('store'));
    }

    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'privacy_policy' => 'nullable|string',
        ]);

        auth('store')->user()->update([
            'privacy_policy' => $request->privacy_policy,
        ]);

        return redirect()->route('store.legal.privacy.edit')->with('success', 'Privacy policy updated successfully');
    }

    public function editTerms()
    {
        $store = auth('store')->user();

        return view('store.legal.terms', compact('store'));
    }

    public function updateTerms(Request $request)
    {
        $request->validate([
            'terms_of_service' => 'nullable|string',
        ]);

        auth('store')->user()->update([
            'terms_of_service' => $request->terms_of_service,
        ]);

        return redirect()->route('store.legal.terms.edit')->with('success', 'Terms of service updated successfully');
    }

    public function editAntiSpam()
    {
        $store = auth('store')->user();

        return view('store.legal.anti-spam', compact('store'));
    }

    public function updateAntiSpam(Request $request)
    {
        $request->validate([
            'anti_spam_policy' => 'nullable|string',
        ]);

        auth('store')->user()->update([
            'anti_spam_policy' => $request->anti_spam_policy,
        ]);

        return redirect()->route('store.legal.anti-spam.edit')->with('success', 'Anti-spam policy updated successfully');
    }

    public function editTabletConsent()
    {
        $store = auth('store')->user();

        return view('store.legal.tablet-consent', compact('store'));
    }

    public function updateTabletConsent(Request $request)
    {
        $request->validate([
            'tablet_consent_text' => 'nullable|string',
        ]);

        auth('store')->user()->update([
            'tablet_consent_text' => $request->tablet_consent_text,
        ]);

        return redirect()->route('store.legal.tablet-consent.edit')->with('success', 'Tablet consent screen updated successfully');
    }
}
