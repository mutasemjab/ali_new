<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreSms;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStores = Store::count();

        $activeStores = Store::whereHas('subscriptions', function ($q) {
            $q->where('from_date', '<=', Carbon::today())
              ->where('to_date', '>=', Carbon::today());
        })->count();

        $totalSmsSent = abs((int) StoreSms::where('type', 'send')->sum('quantity'));

        $remainingSms = (int) Store::sum('total_sms');

        $storesForRecharge = Store::orderBy('name')->get(['id', 'name']);

        $stores = Store::with(['subscriptions' => fn ($q) => $q->latest('to_date')->limit(1)])
            ->orderBy('name')
            ->paginate(10);

        return view('admin.dashboard', compact(
            'totalStores',
            'activeStores',
            'totalSmsSent',
            'remainingSms',
            'storesForRecharge',
            'stores'
        ));
    }
}
