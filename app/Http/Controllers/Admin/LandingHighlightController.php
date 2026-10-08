<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingHighlight;
use Illuminate\Http\Request;

class LandingHighlightController extends Controller
{
    public function index()
    {
        $homeHighlights = LandingHighlight::section(LandingHighlight::SECTION_HOME_HERO)->get();
        $plansHighlights = LandingHighlight::section(LandingHighlight::SECTION_PLANS_FOOTER)->get();

        return view('admin.landing-highlights.index', compact('homeHighlights', 'plansHighlights'));
    }

    public function create()
    {
        return view('admin.landing-highlights.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        LandingHighlight::create($data);

        return redirect()->route('admin.landing-highlights.index')->with('success', 'Highlight added successfully');
    }

    public function edit(LandingHighlight $landingHighlight)
    {
        return view('admin.landing-highlights.edit', ['highlight' => $landingHighlight]);
    }

    public function update(Request $request, LandingHighlight $landingHighlight)
    {
        $data = $this->validateData($request);

        $landingHighlight->update($data);

        return redirect()->route('admin.landing-highlights.index')->with('success', 'Highlight updated successfully');
    }

    public function destroy(LandingHighlight $landingHighlight)
    {
        $landingHighlight->delete();

        return back()->with('success', 'Highlight deleted');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'section' => 'required|in:' . LandingHighlight::SECTION_HOME_HERO . ',' . LandingHighlight::SECTION_PLANS_FOOTER,
            'icon' => 'required|string|max:100',
            'color' => 'required|in:primary,danger,purple,orange,success,warning',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'required|integer|min:0',
        ]);
    }
}
