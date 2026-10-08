<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPlan;
use Illuminate\Http\Request;

class LandingPlanController extends Controller
{
    public function index()
    {
        $landingPlans = LandingPlan::orderBy('sort_order')->get();

        return view('admin.landing-plans.index', compact('landingPlans'));
    }

    public function create()
    {
        return view('admin.landing-plans.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $plan = LandingPlan::create($data);

        $this->saveFeatures($plan, $request->input('features_text', ''));

        return redirect()->route('admin.landing-plans.index')->with('success', 'Plan added successfully');
    }

    public function edit(LandingPlan $landingPlan)
    {
        $landingPlan->load('features');

        return view('admin.landing-plans.edit', ['plan' => $landingPlan]);
    }

    public function update(Request $request, LandingPlan $landingPlan)
    {
        $data = $this->validateData($request);

        $landingPlan->update($data);

        $this->saveFeatures($landingPlan, $request->input('features_text', ''));

        return redirect()->route('admin.landing-plans.index')->with('success', 'Plan updated successfully');
    }

    public function destroy(LandingPlan $landingPlan)
    {
        $landingPlan->delete();

        return back()->with('success', 'Plan deleted');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:200',
            'price' => 'required|string|max:50',
            'price_subtext' => 'nullable|string|max:200',
            'tablets_included' => 'required|integer|min:0',
            'tablets_label' => 'nullable|string|max:100',
            'rate_text' => 'nullable|string|max:100',
            'color' => 'required|in:primary,danger,purple,orange,success,warning',
            'badge_text' => 'nullable|string|max:100',
            'cta_text' => 'required|string|max:50',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data['is_popular'] = $request->boolean('is_popular');

        return $data;
    }

    private function saveFeatures(LandingPlan $plan, string $featuresText): void
    {
        $plan->features()->delete();

        $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $featuresText)));

        foreach (array_values($lines) as $index => $text) {
            $plan->features()->create(['text' => $text, 'sort_order' => $index + 1]);
        }
    }
}
