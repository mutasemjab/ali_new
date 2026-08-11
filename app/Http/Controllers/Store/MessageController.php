<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Jobs\SendStoreSmsCampaign;
use App\Models\Client;
use App\Models\StoreMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = StoreMessage::latest()->paginate(15);

        return view('store.messages.index', compact('messages'));
    }

    public function create()
    {
        $clientsCount = Client::count();

        return view('store.messages.create', compact('clientsCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:600',
        ]);

        $store = auth()->guard('store')->user();
        $clients = Client::all();

        if ($clients->isEmpty()) {
            return back()->with('error', 'There are no clients to send this message to')->withInput();
        }

        if ($store->total_sms < $clients->count()) {
            return back()->with('error', 'Insufficient SMS balance to send this campaign')->withInput();
        }

        $storeMessage = StoreMessage::create([
            'content' => $request->content,
            'recipients_count' => $clients->count(),
            'status' => 'pending',
        ]);

        foreach ($clients as $client) {
            $storeMessage->recipients()->create([
                'client_id' => $client->id,
                'phone' => $client->phone,
                'status' => 'pending',
            ]);
        }

        SendStoreSmsCampaign::dispatch($storeMessage);

        return redirect()->route('store.messages.index')->with('success', 'Campaign has been queued for sending');
    }

    public function show(StoreMessage $message)
    {
        $message->load('recipients');

        return view('store.messages.show', compact('message'));
    }

    public function destroy(StoreMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Message deleted');
    }
}
