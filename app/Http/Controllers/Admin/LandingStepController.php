<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingStep;
use Illuminate\Http\Request;

class LandingStepController extends Controller
{
    public function index()
    {
        $landingSteps = LandingStep::orderBy('sort_order')->get();

        return view('admin.landing-steps.index', compact('landingSteps'));
    }

    public function create()
    {
        return view('admin.landing-steps.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);

        if ($request->hasFile('image')) {
            $data['image'] = 'assets/uploads/landing-steps/' . uploadImage('assets/uploads/landing-steps', $request->file('image'));
        }

        $step = LandingStep::create($data);

        $this->saveFeatures($step, $request->input('features_text', ''));

        return redirect()->route('admin.landing-steps.index')->with('success', 'Step added successfully');
    }

    public function edit(LandingStep $landingStep)
    {
        $landingStep->load('features');

        return view('admin.landing-steps.edit', ['step' => $landingStep]);
    }

    public function update(Request $request, LandingStep $landingStep)
    {
        $data = $this->validateData($request, false);

        if ($request->hasFile('image')) {
            $data['image'] = 'assets/uploads/landing-steps/' . uploadImage('assets/uploads/landing-steps', $request->file('image'));
        }

        $landingStep->update($data);

        $this->saveFeatures($landingStep, $request->input('features_text', ''));

        return redirect()->route('admin.landing-steps.index')->with('success', 'Step updated successfully');
    }

    public function destroy(LandingStep $landingStep)
    {
        $landingStep->delete();

        return back()->with('success', 'Step deleted');
    }

    private function validateData(Request $request, bool $imageRequired): array
    {
        return $request->validate([
            'number' => 'required|integer|min:1',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|max:4096',
            'color' => 'required|in:primary,danger,purple,orange,success,warning',
            'sort_order' => 'required|integer|min:0',
        ]);
    }

    private function saveFeatures(LandingStep $step, string $featuresText): void
    {
        $step->features()->delete();

        $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $featuresText)));

        foreach (array_values($lines) as $index => $text) {
            $step->features()->create(['text' => $text, 'sort_order' => $index + 1]);
        }
    }
}
