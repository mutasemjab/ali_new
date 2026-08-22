<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\WeeklyAd;
use Illuminate\Http\Request;

class WeeklyAdController extends Controller
{
    public function index()
    {
        $weeklyAds = WeeklyAd::latest()->paginate(15);

        return view('store.weekly-ads.index', compact('weeklyAds'));
    }

    public function create()
    {
        return view('store.weekly-ads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        $filename = uploadImage('assets/uploads/weekly-ads', $request->file('photo'));

        WeeklyAd::create([
            'photo' => 'assets/uploads/weekly-ads/' . $filename,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ]);

        return redirect()->route('store.weekly-ads.index')->with('success', 'Weekly ad added successfully');
    }

    public function edit(WeeklyAd $weeklyAd)
    {
        return view('store.weekly-ads.edit', compact('weeklyAd'));
    }

    public function update(Request $request, WeeklyAd $weeklyAd)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        $data = [
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ];

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/weekly-ads', $request->file('photo'));
            $data['photo'] = 'assets/uploads/weekly-ads/' . $filename;
        }

        $weeklyAd->update($data);

        return redirect()->route('store.weekly-ads.index')->with('success', 'Weekly ad updated successfully');
    }

    public function destroy(WeeklyAd $weeklyAd)
    {
        $weeklyAd->delete();

        return back()->with('success', 'Weekly ad deleted');
    }
}
