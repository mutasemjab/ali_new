<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Jobs\SendStoreSmsCampaign;
use App\Models\Client;
use App\Models\StoreMessage;
use App\Models\WeeklyAd;
use Illuminate\Http\Request;

class WeeklyAdController extends Controller
{
    public function index()
    {
        $weeklyAds = WeeklyAd::latest()->paginate(15);

        return view('store.weekly-ads.index', compact('weeklyAds'));
    }

    public function create()
    {
        return view('store.weekly-ads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        $filename = uploadImage('assets/uploads/weekly-ads', $request->file('photo'));

        WeeklyAd::create([
            'photo' => 'assets/uploads/weekly-ads/' . $filename,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ]);

        return redirect()->route('store.weekly-ads.index')->with('success', 'Weekly ad added successfully');
    }

    public function edit(WeeklyAd $weeklyAd)
    {
        return view('store.weekly-ads.edit', compact('weeklyAd'));
    }

    public function update(Request $request, WeeklyAd $weeklyAd)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        $data = [
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ];

        if ($request->hasFile('photo')) {
            $filename = uploadImage('assets/uploads/weekly-ads', $request->file('photo'));
            $data['photo'] = 'assets/uploads/weekly-ads/' . $filename;
        }

        $weeklyAd->update($data);

        return redirect()->route('store.weekly-ads.index')->with('success', 'Weekly ad updated successfully');
    }

    public function destroy(WeeklyAd $weeklyAd)
    {
        $weeklyAd->delete();

        return back()->with('success', 'Weekly ad deleted');
    }

    public function smsCreate(WeeklyAd $weeklyAd)
    {
        $clients = Client::orderBy('name')->get();

        return view('store.weekly-ads.sms', compact('weeklyAd', 'clients'));
    }

    public function smsSend(Request $request, WeeklyAd $weeklyAd)
    {
        $request->validate([
            'recipients' => 'required|in:all,selected',
            'client_ids' => 'required_if:recipients,selected|array',
            'client_ids.*' => 'integer|exists:clients,id',
        ]);

        $store = auth('store')->user();

        $clients = $request->recipients === 'all'
            ? Client::all()
            : Client::whereIn('id', $request->client_ids)->get();

        if ($clients->isEmpty()) {
            return back()->with('error', 'No clients selected to send this message to');
        }

        if ($store->total_sms < $clients->count()) {
            return back()->with('error', 'Insufficient SMS balance to send this campaign');
        }

        $content = $this->buildSmsTemplate($store, $weeklyAd);

        $storeMessage = StoreMessage::create([
            'content' => $content,
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

        return redirect()->route('store.weekly-ads.index')->with('success', 'Weekly ad SMS has been queued for sending to ' . $clients->count() . ' client(s)');
    }

    private function buildSmsTemplate($store, WeeklyAd $weeklyAd): string
    {
        return $store->name . "\n"
            . "WEEKLY AD\n"
            . $weeklyAd->start_at->format('m/d/Y') . ' TO ' . $weeklyAd->end_at->format('m/d/Y') . "\n\n"
            . 'Tap to view specials! ' . $weeklyAd->public_url . "\n"
            . 'Text STOP to opt-out.';
    }
}
