<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $socials = Social::latest()->paginate(15);

        return view('store.socials.index', compact('socials'));
    }

    public function create()
    {
        return view('store.socials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'link' => 'required|url|max:255',
            'photo' => 'required|image|max:2048',
        ]);

        $filename = uploadImage('assets/uploads/socials', $request->file('photo'));

        Social::create([
            'name' => $request->name,
            'link' => $request->link,
            'photo' => 'assets/uploads/socials/' . $filename,
        ]);

        return redirect()->route('store.socials.index')->with('success', 'Social link added successfully');
    }

    public function edit(Social $social)
    {
        return view('store.socials.edit', compact('social'));
    }

    public function update(Request $request, Social $social)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'link' => 'required|url|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'link' => $request->link,
        ];

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/socials', $request->file('photo'));
            $data['photo'] = 'assets/uploads/socials/' . $filename;
        }

        $social->update($data);

        return redirect()->route('store.socials.index')->with('success', 'Social link updated successfully');
    }

    public function destroy(Social $social)
    {
        $social->delete();

        return back()->with('success', 'Social link deleted');
    }
}
