<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\CouponClient;
use Illuminate\Http\Request;

class CouponClientController extends Controller
{
    public function index(Request $request)
    {
        $couponClients = CouponClient::with(['client', 'coupon'])
            ->when($request->coupon_id, fn ($q, $id) => $q->where('coupon_id', $id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.coupon-clients.index', compact('couponClients'));
    }

    public function destroy(CouponClient $couponClient)
    {
        $couponClient->delete();

        return back()->with('success', 'Clip revoked');
    }
}
