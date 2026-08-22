<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->paginate(15);

        return view('store.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('store.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:50',
        ]);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/locations', $request->file('photo'));
            $data['photo'] = 'assets/uploads/locations/' . $filename;
        }

        Location::create($data);

        return redirect()->route('store.locations.index')->with('success', 'Location added successfully');
    }

    public function edit(Location $location)
    {
        return view('store.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:50',
        ]);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/locations', $request->file('photo'));
            $data['photo'] = 'assets/uploads/locations/' . $filename;
        }

        $location->update($data);

        return redirect()->route('store.locations.index')->with('success', 'Location updated successfully');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return back()->with('success', 'Location deleted');
    }
}
