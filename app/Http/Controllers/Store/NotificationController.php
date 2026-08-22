<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(15);

        return view('store.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('store.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string|max:500',
        ]);

        Notification::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('store.notifications.index')->with('success', 'Notification sent successfully');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return back()->with('success', 'Notification deleted');
    }
}
