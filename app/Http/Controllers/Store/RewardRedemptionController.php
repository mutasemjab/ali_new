<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\RewardRedemption;
use Illuminate\Http\Request;

class RewardRedemptionController extends Controller
{
    public function index(Request $request)
    {
        $rewardRedemptions = RewardRedemption::with(['client', 'rewardProduct'])
            ->when($request->reward_product_id, fn ($q, $id) => $q->where('reward_product_id', $id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.reward-redemptions.index', compact('rewardRedemptions'));
    }

    public function destroy(RewardRedemption $rewardRedemption)
    {
        $rewardRedemption->delete();

        return back()->with('success', 'Redemption record deleted');
    }
}
