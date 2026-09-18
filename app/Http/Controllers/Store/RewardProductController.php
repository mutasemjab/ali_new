<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\RewardProduct;
use Illuminate\Http\Request;

class RewardProductController extends Controller
{
    public function index()
    {
        $rewardProducts = RewardProduct::orderBy('points_required')->paginate(15);

        return view('store.reward-products.index', compact('rewardProducts'));
    }

    public function create()
    {
        return view('store.reward-products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'image' => 'required|image|max:2048',
            'points_required' => 'required|integer|min:1',
            'barcode' => 'required|string|max:100',
        ]);

        $filename = uploadImage('assets/uploads/reward-products', $request->file('image'));

        RewardProduct::create([
            'name' => $request->name,
            'image' => 'assets/uploads/reward-products/' . $filename,
            'points_required' => $request->points_required,
            'barcode' => $request->barcode,
        ]);

        return redirect()->route('store.reward-products.index')->with('success', 'Reward added successfully');
    }

    public function edit(RewardProduct $rewardProduct)
    {
        return view('store.reward-products.edit', compact('rewardProduct'));
    }

    public function update(Request $request, RewardProduct $rewardProduct)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'image' => 'nullable|image|max:2048',
            'points_required' => 'required|integer|min:1',
            'barcode' => 'required|string|max:100',
        ]);

        $data = [
            'name' => $request->name,
            'points_required' => $request->points_required,
            'barcode' => $request->barcode,
        ];

        if ($request->hasFile('image')) {
            $filename = uploadImage('assets/uploads/reward-products', $request->file('image'));
            $data['image'] = 'assets/uploads/reward-products/' . $filename;
        }

        $rewardProduct->update($data);

        return redirect()->route('store.reward-products.index')->with('success', 'Reward updated successfully');
    }

    public function destroy(RewardProduct $rewardProduct)
    {
        $rewardProduct->delete();

        return back()->with('success', 'Reward deleted');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'points_per_visit' => 'required|integer|min:0',
        ]);

        auth('store')->user()->update([
            'points_per_visit' => $request->points_per_visit,
        ]);

        return redirect()->route('store.reward-products.index')->with('success', 'Points setting updated successfully');
    }
}
