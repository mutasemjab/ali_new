<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    public function privacy(Store $store)
    {
        $privacyPolicy = $store->privacy_policy;

        return view('public.privacy', compact('store', 'privacyPolicy'));
    }

    public function termsOfService(Store $store)
    {
        $termsOfService = $store->terms_of_service;

        return view('public.terms', compact('store', 'termsOfService'));
    }

    public function antiSpamPolicy(Store $store)
    {
        $antiSpamPolicy = $store->anti_spam_policy;

        return view('public.anti-spam', compact('store', 'antiSpamPolicy'));
    }
}
