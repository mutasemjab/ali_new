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
            'maps_link' => 'required|url|max:1000',
            'phone' => 'nullable|string|max:50',
        ]);

        $coords = $this->extractLatLngFromMapsLink($request->maps_link);

        if (! $coords) {
            return back()->withInput()->withErrors([
                'maps_link' => 'Could not read coordinates from that link. Open the location in Google Maps, tap Share, copy the link, and paste it here.',
            ]);
        }

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'lat' => $coords[0],
            'lng' => $coords[1],
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
            'maps_link' => 'required|url|max:1000',
            'phone' => 'nullable|string|max:50',
        ]);

        $coords = $this->extractLatLngFromMapsLink($request->maps_link);

        if (! $coords) {
            return back()->withInput()->withErrors([
                'maps_link' => 'Could not read coordinates from that link. Open the location in Google Maps, tap Share, copy the link, and paste it here.',
            ]);
        }

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'lat' => $coords[0],
            'lng' => $coords[1],
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

    /**
     * Pulls [lat, lng] out of a Google Maps URL. Handles the normal share-link shapes
     * (.../@lat,lng,17z..., ...!3dlat!4dlng..., ...?q=lat,lng) and short links
     * (maps.app.goo.gl / goo.gl/maps) by resolving the redirect first.
     */
    private function extractLatLngFromMapsLink(string $url): ?array
    {
        $url = trim($url);

        if (preg_match('/(maps\.app\.goo\.gl|goo\.gl\/maps)/i', $url)) {
            $url = $this->resolveRedirect($url) ?? $url;
        }

        $patterns = [
            '/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/',
            '/@(-?\d+\.\d+),(-?\d+\.\d+)/',
            '/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/',
            '/[?&]ll=(-?\d+\.\d+),(-?\d+\.\d+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return [(float) $matches[1], (float) $matches[2]];
            }
        }

        return null;
    }

    private function resolveRedirect(string $url): ?string
    {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0',
        ]);

        curl_exec($ch);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        return $finalUrl ?: null;
    }
}
