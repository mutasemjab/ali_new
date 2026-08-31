<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Store;

class StoreController extends Controller
{
    public function privacy(Store $store)
    {
        $privacyPolicy = AppSetting::current()->privacy_policy;

        return view('public.privacy', compact('store', 'privacyPolicy'));
    }
}
