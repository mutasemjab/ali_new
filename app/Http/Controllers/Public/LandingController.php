<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\LandingHighlight;
use App\Models\LandingPlan;
use App\Models\LandingPlanInquiry;
use App\Models\LandingSetting;
use App\Models\LandingStep;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function __construct()
    {
        // This whole marketing site is always English, with no /en/ prefix in the URL.
        app()->setLocale('en');
    }

    public function home()
    {
        $setting = LandingSetting::current();
        $heroHighlights = LandingHighlight::section(LandingHighlight::SECTION_HOME_HERO)->get();
        $steps = LandingStep::with('features')->orderBy('sort_order')->get();

        return view('landing.home', compact('setting', 'heroHighlights', 'steps'));
    }

    public function plans()
    {
        $setting = LandingSetting::current();
        $plans = LandingPlan::with('features')->orderBy('sort_order')->get();
        $footerHighlights = LandingHighlight::section(LandingHighlight::SECTION_PLANS_FOOTER)->get();

        return view('landing.plans', compact('setting', 'plans', 'footerHighlights'));
    }

    public function storePlanInquiry(Request $request)
    {
        $data = $request->validate([
            'landing_plan_id' => 'nullable|exists:landing_plans,id',
            'name' => 'required|string|max:200',
            'company' => 'nullable|string|max:200',
            'email' => 'required|email|max:200',
            'phone' => 'required|string|max:50',
            'message' => 'nullable|string|max:2000',
        ]);

        $plan = $data['landing_plan_id'] ? LandingPlan::find($data['landing_plan_id']) : null;
        $data['plan_name'] = $plan?->name;

        LandingPlanInquiry::create($data);

        return redirect()->route('landing.plans')->with('success', "Thanks! We'll be in touch shortly.");
    }

    public function features()
    {
        $setting = LandingSetting::current();
        $heroHighlights = LandingHighlight::section(LandingHighlight::SECTION_HOME_HERO)->get();
        $footerHighlights = LandingHighlight::section(LandingHighlight::SECTION_PLANS_FOOTER)->get();

        return view('landing.features', compact('setting', 'heroHighlights', 'footerHighlights'));
    }

    public function howItWorks()
    {
        $setting = LandingSetting::current();
        $steps = LandingStep::with('features')->orderBy('sort_order')->get();

        return view('landing.how-it-works', compact('setting', 'steps'));
    }

    public function about()
    {
        $setting = LandingSetting::current();

        return view('landing.about', compact('setting'));
    }

    public function contact()
    {
        $setting = LandingSetting::current();

        return view('landing.contact', compact('setting'));
    }

    public function privacyPolicy()
    {
        $setting = LandingSetting::current();
        $title = 'Privacy Policy';
        $content = AppSetting::current()->privacy_policy;

        return view('landing.legal', compact('setting', 'title', 'content'));
    }

    public function termsOfService()
    {
        $setting = LandingSetting::current();
        $title = 'Terms of Service';
        $content = AppSetting::current()->terms_of_service;

        return view('landing.legal', compact('setting', 'title', 'content'));
    }

    public function antiSpamPolicy()
    {
        $setting = LandingSetting::current();
        $title = 'Anti-Spam Policy';
        $content = AppSetting::current()->anti_spam_policy;

        return view('landing.legal', compact('setting', 'title', 'content'));
    }
}
