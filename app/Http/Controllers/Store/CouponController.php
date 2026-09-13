<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->expires_in_days, function ($q, $days) {
                $q->whereDate('end_at', '>=', now()->toDateString())
                    ->whereDate('end_at', '<=', now()->addDays((int) $days)->toDateString());
            })
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        return view('store.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('store.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'terms' => 'nullable|string',
            'photo' => 'required|image|max:2048',
            'status' => 'required|in:clip,active,expired',
            'save_price' => 'required|string|max:100',
            'price' => 'required|string|max:100',
            'price_after_discount' => 'required|string|max:100',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'time_when_clipped' => 'required|integer|min:1',
            'barcode' => 'required|string|max:100',
        ]);

        $filename = uploadImage('assets/uploads/coupons', $request->file('photo'));

        Coupon::create([
            'name' => $request->name,
            'description' => $request->description,
            'terms' => $request->terms,
            'photo' => 'assets/uploads/coupons/' . $filename,
            'status' => $request->status,
            'save_price' => $request->save_price,
            'price' => $request->price,
            'price_after_discount' => $request->price_after_discount,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'time_when_clipped' => $request->time_when_clipped,
            'barcode' => $request->barcode,
            'sort_order' => (Coupon::max('sort_order') ?? 0) + 1,
        ]);

        return redirect()->route('store.coupons.index')->with('success', 'Coupon added successfully');
    }

    public function edit(Coupon $coupon)
    {
        return view('store.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'terms' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:clip,active,expired',
            'save_price' => 'required|string|max:100',
            'price' => 'required|string|max:100',
            'price_after_discount' => 'required|string|max:100',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'time_when_clipped' => 'required|integer|min:1',
            'barcode' => 'required|string|max:100',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'terms' => $request->terms,
            'status' => $request->status,
            'save_price' => $request->save_price,
            'price' => $request->price,
            'price_after_discount' => $request->price_after_discount,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'time_when_clipped' => $request->time_when_clipped,
            'barcode' => $request->barcode,
        ];

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/coupons', $request->file('photo'));
            $data['photo'] = 'assets/uploads/coupons/' . $filename;
        }

        $coupon->update($data);

        // Editing the coupon resets it: clients who already clipped it can clip it again.
        $coupon->couponClients()->delete();

        return redirect()->route('store.coupons.index')->with('success', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('success', 'Coupon deleted');
    }

    public function reorder(Request $request, Coupon $coupon)
    {
        $request->validate([
            'sort_order' => 'required|integer|min:1',
        ]);

        $newOrder = (int) $request->sort_order;

        DB::transaction(function () use ($coupon, $newOrder) {
            $existing = Coupon::where('sort_order', $newOrder)
                ->where('id', '!=', $coupon->id)
                ->first();

            if ($existing) {
                $existing->update(['sort_order' => $coupon->sort_order]);
            }

            $coupon->update(['sort_order' => $newOrder]);
        });

        return back()->with('success', 'Coupon order updated');
    }
}
