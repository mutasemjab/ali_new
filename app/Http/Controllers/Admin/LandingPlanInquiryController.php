<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPlanInquiry;

class LandingPlanInquiryController extends Controller
{
    public function index()
    {
        $inquiries = LandingPlanInquiry::latest()->paginate(20);

        return view('admin.landing-plan-inquiries.index', compact('inquiries'));
    }

    public function toggle(LandingPlanInquiry $landingPlanInquiry)
    {
        $landingPlanInquiry->update(['is_read' => ! $landingPlanInquiry->is_read]);

        return back()->with('success', $landingPlanInquiry->is_read ? 'Marked as read' : 'Marked as unread');
    }

    public function destroy(LandingPlanInquiry $landingPlanInquiry)
    {
        $landingPlanInquiry->delete();

        return back()->with('success', 'Inquiry deleted');
    }
}
