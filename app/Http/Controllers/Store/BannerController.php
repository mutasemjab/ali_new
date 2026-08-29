<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(15);

        return view('store.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('store.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $filename = uploadImage('assets/uploads/banners', $request->file('photo'));

        Banner::create([
            'photo' => 'assets/uploads/banners/' . $filename,
        ]);

        return redirect()->route('store.banners.index')->with('success', 'Banner added successfully');
    }

    public function edit(Banner $banner)
    {
        return view('store.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/banners', $request->file('photo'));
            $banner->update(['photo' => 'assets/uploads/banners/' . $filename]);
        }

        return redirect()->route('store.banners.index')->with('success', 'Banner updated successfully');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return back()->with('success', 'Banner deleted');
    }
}
