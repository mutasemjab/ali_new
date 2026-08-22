<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreSms;
use Illuminate\Http\Request;

class StoreSmsController extends Controller
{
    public function store(Request $request, Store $store)
    {
        $request->validate([
            'type' => 'required|in:recharge,refund,adjustment',
            'quantity' => 'required|integer',
            'note' => 'nullable|string|max:500',
        ]);

        $quantity = in_array($request->type, ['recharge']) ? abs($request->quantity) : $request->quantity;
        $balanceAfter = max(0, $store->total_sms + $quantity);

        StoreSms::create([
            'store_id' => $store->id,
            'type' => $request->type,
            'quantity' => $quantity,
            'balance_after' => $balanceAfter,
            'note' => $request->note,
            'created_by' => auth('admin')->id(),
        ]);

        $store->update(['total_sms' => $balanceAfter]);

        return back()->with('success', 'SMS balance updated successfully');
    }

    /**
     * Quick "add credit" action from the dashboard: pick any store, add a fixed
     * amount of SMS credit in one step (always a recharge, no refund/adjustment).
     */
    public function quickStore(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $store = Store::findOrFail($request->store_id);
        $balanceAfter = $store->total_sms + $request->quantity;

        StoreSms::create([
            'store_id' => $store->id,
            'type' => 'recharge',
            'quantity' => $request->quantity,
            'balance_after' => $balanceAfter,
            'note' => 'Quick recharge from dashboard',
            'created_by' => auth('admin')->id(),
        ]);

        $store->update(['total_sms' => $balanceAfter]);

        return back()->with('success', "Added {$request->quantity} SMS credits to {$store->name}");
    }
}
