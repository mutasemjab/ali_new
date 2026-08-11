<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $store = auth()->guard('store')->user();

        $clientsCount = $store->clients()->count();
        $smsBalance = $store->total_sms;
        $recentMessages = $store->messages()->latest()->take(5)->get();
        $activeSubscription = $store->subscriptions()->orderByDesc('to_date')->first();

        return view('store.dashboard', compact('clientsCount', 'smsBalance', 'recentMessages', 'activeSubscription'));
    }
}
