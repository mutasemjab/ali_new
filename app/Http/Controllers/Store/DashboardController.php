<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $store = auth()->guard('store')->user();

        $from = $request->filled('from') ? Carbon::parse($request->from) : Carbon::now()->startOfMonth();
        $to = $request->filled('to') ? Carbon::parse($request->to) : Carbon::now();

        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        $rangeStart = $from->copy()->startOfDay();
        $rangeEnd = $to->copy()->endOfDay();

        $clientsCount = $store->clients()->whereBetween('created_at', [$rangeStart, $rangeEnd])->count();
        $smsBalance = $store->total_sms;
        $categoriesCount = $store->categories()->whereBetween('created_at', [$rangeStart, $rangeEnd])->count();
        $productsCount = $store->products()->whereBetween('created_at', [$rangeStart, $rangeEnd])->count();
        $adsCount = $store->ads()->whereBetween('created_at', [$rangeStart, $rangeEnd])->count();
        $feedbackCount = $store->feedbacks()->whereBetween('created_at', [$rangeStart, $rangeEnd])->count();
        $smsSentCount = abs((int) $store->smsLedger()
            ->where('type', 'send')
            ->whereBetween('created_at', [$rangeStart, $rangeEnd])
            ->sum('quantity'));
        $recentMessages = $store->messages()
            ->whereBetween('created_at', [$rangeStart, $rangeEnd])
            ->latest()
            ->take(5)
            ->get();

        // The active subscription is a current-state fact (are we paid up right now?),
        // not an event that happened within the chosen range, so it stays unfiltered.
        $activeSubscription = $store->subscriptions()->orderByDesc('to_date')->first();

        return view('store.dashboard', compact(
            'clientsCount',
            'smsBalance',
            'categoriesCount',
            'productsCount',
            'adsCount',
            'feedbackCount',
            'smsSentCount',
            'recentMessages',
            'activeSubscription',
            'from',
            'to'
        ));
    }
}
