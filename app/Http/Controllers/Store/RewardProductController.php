<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\RewardProduct;
use Illuminate\Http\Request;

class RewardProductController extends Controller
{
    public function index()
    {
        $rewardProducts = RewardProduct::orderBy('visits_required')->paginate(15);

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
            'visits_required' => 'required|integer|min:1',
        ]);

        $filename = uploadImage('assets/uploads/reward-products', $request->file('image'));

        RewardProduct::create([
            'name' => $request->name,
            'image' => 'assets/uploads/reward-products/' . $filename,
            'visits_required' => $request->visits_required,
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
            'visits_required' => 'required|integer|min:1',
        ]);

        $data = [
            'name' => $request->name,
            'visits_required' => $request->visits_required,
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
}
