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

    /**
     * These three mirror privacy()/termsOfService()/antiSpamPolicy() above, but take no
     * {store} — the store is resolved from the current subdomain instead (e.g. visiting
     * laesperanzamarket.flyerall.net/store/legal/privacy), so the same short link works
     * for every store. 404s when visited on the root domain or an unclaimed subdomain.
     */
    public function subdomainPrivacy()
    {
        $store = Store::resolveFromSubdomain();
        abort_if(! $store, 404);

        return view('public.privacy', ['store' => $store, 'privacyPolicy' => $store->privacy_policy]);
    }

    public function subdomainTerms()
    {
        $store = Store::resolveFromSubdomain();
        abort_if(! $store, 404);

        return view('public.terms', ['store' => $store, 'termsOfService' => $store->terms_of_service]);
    }

    public function subdomainAntiSpam()
    {
        $store = Store::resolveFromSubdomain();
        abort_if(! $store, 404);

        return view('public.anti-spam', ['store' => $store, 'antiSpamPolicy' => $store->anti_spam_policy]);
    }
}
