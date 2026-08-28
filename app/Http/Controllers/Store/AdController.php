<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::with('products', 'images')->latest()->paginate(15);

        return view('store.ads.index', compact('ads'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('store.ads.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:image,products',
            'images' => 'required_if:type,image|nullable|array|min:1',
            'images.*' => 'image|max:8048',
            'products' => 'required_if:type,products|nullable|array|min:1',
            'products.*' => [
                'integer',
                Rule::exists('products', 'id')->where('store_id', auth('store')->id()),
            ],
            'expires_at' => 'nullable|date|after:now',
        ]);

        $ad = Ad::create([
            'type' => $request->type,
            'expires_at' => $request->expires_at,
        ]);

        if ($request->type === 'image') {
            foreach ($request->file('images') as $image) {
                $ad->images()->create([
                    'image' => 'assets/uploads/ads/' . uploadImage('assets/uploads/ads', $image),
                ]);
            }
        }

        if ($request->type === 'products') {
            $ad->products()->sync($request->input('products', []));
        }

        return redirect()->route('store.ads.index')->with('success', 'Ad created successfully. Link: ' . $ad->public_url);
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        return back()->with('success', 'Ad deleted');
    }
}
