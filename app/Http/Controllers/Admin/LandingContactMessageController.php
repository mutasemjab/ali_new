<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingContactMessage;

class LandingContactMessageController extends Controller
{
    public function index()
    {
        $messages = LandingContactMessage::latest()->paginate(20);

        return view('admin.landing-contact-messages.index', compact('messages'));
    }

    public function toggle(LandingContactMessage $landingContactMessage)
    {
        $landingContactMessage->update(['is_read' => ! $landingContactMessage->is_read]);

        return back()->with('success', $landingContactMessage->is_read ? 'Marked as read' : 'Marked as unread');
    }

    public function destroy(LandingContactMessage $landingContactMessage)
    {
        $landingContactMessage->delete();

        return back()->with('success', 'Message deleted');
    }
}
