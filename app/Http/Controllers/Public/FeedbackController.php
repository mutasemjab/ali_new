<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Store;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create(Store $store)
    {
        return view('public.feedback', compact('store'));
    }

    public function store(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'phone' => 'required|string|max:50',
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        return back()->with('success', 'شكراً لك، تم إرسال ملاحظتك بنجاح');
    }
}
