<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Jobs\SendStoreSmsCampaign;
use App\Models\Ad;
use App\Models\Client;
use App\Models\Product;
use App\Models\StoreMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::with('products', 'images')->latest()->paginate(15);

        return view('store.ads.index', compact('ads'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('store.ads.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:image,products',
            'images' => 'required_if:type,image|nullable|array|min:1',
            'images.*' => 'image|max:8048',
            'products' => 'required_if:type,products|nullable|array|min:1',
            'products.*' => [
                'integer',
                Rule::exists('products', 'id')->where('store_id', auth('store')->id()),
            ],
            'expires_at' => 'nullable|date|after:now',
        ]);

        $ad = Ad::create([
            'type' => $request->type,
            'expires_at' => $request->expires_at,
        ]);

        if ($request->type === 'image') {
            foreach ($request->file('images') as $image) {
                $ad->images()->create([
                    'image' => 'assets/uploads/ads/' . uploadImage('assets/uploads/ads', $image),
                ]);
            }
        }

        if ($request->type === 'products') {
            $ad->products()->sync($request->input('products', []));
        }

        return redirect()->route('store.ads.index')->with('success', 'Ad created successfully. Link: ' . $ad->public_url);
    }

    public function edit(Ad $ad)
    {
        $ad->load('products', 'images');
        $products = Product::orderBy('name')->get();

        return view('store.ads.edit', compact('ad', 'products'));
    }

    public function update(Request $request, Ad $ad)
    {
        $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'image|max:8048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer|exists:ad_images,id',
            'products' => 'required_if:type,products|nullable|array',
            'products.*' => [
                'integer',
                Rule::exists('products', 'id')->where('store_id', auth('store')->id()),
            ],
            'expires_at' => 'nullable|date',
        ]);

        $ad->update([
            'expires_at' => $request->expires_at,
        ]);

        if ($ad->type === 'image') {
            if ($request->filled('remove_images')) {
                $ad->images()->whereIn('id', $request->remove_images)->delete();
            }

            foreach ($request->file('images', []) as $image) {
                $ad->images()->create([
                    'image' => 'assets/uploads/ads/' . uploadImage('assets/uploads/ads', $image),
                ]);
            }
        }

        if ($ad->type === 'products') {
            $ad->products()->sync($request->input('products', []));
        }

        return redirect()->route('store.ads.index')->with('success', 'Ad updated successfully');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        return back()->with('success', 'Ad deleted');
    }

    public function smsCreate(Ad $ad)
    {
        $clients = Client::orderBy('name')->get();

        return view('store.ads.sms', compact('ad', 'clients'));
    }

    public function smsSend(Request $request, Ad $ad)
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

        $content = $this->buildSmsTemplate($store, $ad);

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

        return redirect()->route('store.ads.index')->with('success', 'Ad SMS has been queued for sending to ' . $clients->count() . ' client(s)');
    }

    private function buildSmsTemplate($store, Ad $ad): string
    {
        $message = $store->name . "\n\n"
            . 'Tap to view now! ' . $ad->public_url;

        if ($ad->expires_at) {
            $message .= "\n" . 'Offer ends ' . $ad->expires_at->format('m/d/Y h:i A');
        }

        return $message . "\n" . 'Text STOP to opt-out.';
    }
}
