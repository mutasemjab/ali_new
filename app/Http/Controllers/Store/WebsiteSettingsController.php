<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\StoreLandingStep;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    public function edit()
    {
        $store = auth('store')->user();
        $steps = $store->landingSteps;

        return view('store.website.edit', compact('store', 'steps'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'nullable|string|max:200',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_image' => 'nullable|image|max:2048',
            'about_title' => 'nullable|string|max:200',
            'about_body' => 'nullable|string|max:5000',
        ]);

        $store = auth('store')->user();

        $data = $request->only(['hero_title', 'hero_subtitle', 'about_title', 'about_body']);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = 'assets/uploads/stores/' . uploadImage('assets/uploads/stores', $request->file('hero_image'));
        }

        $store->update($data);

        return redirect()->route('store.website.edit')->with('success', 'Website content updated successfully');
    }

    public function storeStep(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $store = auth('store')->user();

        $data = [
            'store_id' => $store->id,
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => ((int) $store->landingSteps()->max('sort_order')) + 1,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = 'assets/uploads/stores/' . uploadImage('assets/uploads/stores', $request->file('image'));
        }

        StoreLandingStep::create($data);

        return back()->with('success', 'Step added successfully');
    }

    public function updateStep(Request $request, StoreLandingStep $step)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = 'assets/uploads/stores/' . uploadImage('assets/uploads/stores', $request->file('image'));
        }

        $step->update($data);

        return back()->with('success', 'Step updated successfully');
    }

    public function destroyStep(StoreLandingStep $step)
    {
        $step->delete();

        return back()->with('success', 'Step removed');
    }
}
