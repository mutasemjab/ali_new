<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreSubscriptionController extends Controller
{
    public function store(Request $request, Store $store)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:cash,visa,bank_transfer',
            'note' => 'nullable|string|max:500',
        ]);

        $store->subscriptions()->create($request->only('from_date', 'to_date', 'amount', 'payment_type', 'note'));

        return back()->with('success', 'Subscription recorded successfully');
    }
}
