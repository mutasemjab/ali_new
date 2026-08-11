<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    public function privacy(Store $store)
    {
        return view('public.privacy', compact('store'));
    }
}
