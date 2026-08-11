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
}
