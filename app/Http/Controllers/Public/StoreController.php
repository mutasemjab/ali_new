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
}
