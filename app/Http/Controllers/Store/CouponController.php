<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->latest()
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
            'description' => 'required|string',
            'terms' => 'required|string',
            'photo' => 'required|image|max:2048',
            'status' => 'required|in:clip,active,expired',
            'save_price' => 'required|string|max:100',
            'price' => 'required|string|max:100',
            'price_after_discount' => 'required|string|max:100',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'time_when_clipped' => 'required|string|max:100',
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
            'barcode' => strtoupper(Str::random(12)),
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
            'description' => 'required|string',
            'terms' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:clip,active,expired',
            'save_price' => 'required|string|max:100',
            'price' => 'required|string|max:100',
            'price_after_discount' => 'required|string|max:100',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'time_when_clipped' => 'required|string|max:100',
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
        ];

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/coupons', $request->file('photo'));
            $data['photo'] = 'assets/uploads/coupons/' . $filename;
        }

        $coupon->update($data);

        return redirect()->route('store.coupons.index')->with('success', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('success', 'Coupon deleted');
    }
}
