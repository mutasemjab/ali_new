<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::when($request->search, fn ($q, $s) => $q->where(fn ($q2) => $q2
                ->where('name', 'like', "%$s%")
                ->orWhere('phone', 'like', "%$s%")
            ))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('store.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'phone' => 'required|string|max:50|unique:clients,phone,NULL,id,store_id,' . auth('store')->id(),
        ]);

        Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'number_of_visit' => 0,
            'total_points' => 0,
        ]);

        return redirect()->route('store.clients.index')->with('success', 'Client added successfully');
    }

    public function edit(Client $client)
    {
        return view('store.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'phone' => 'required|string|max:50|unique:clients,phone,' . $client->id . ',id,store_id,' . auth('store')->id(),
            'number_of_visit' => 'nullable|integer|min:0',
            'total_points' => 'nullable|integer|min:0',
        ]);

        $client->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'number_of_visit' => $request->number_of_visit ?? $client->number_of_visit,
            'total_points' => $request->total_points ?? $client->total_points,
        ]);

        return redirect()->route('store.clients.index')->with('success', 'Client updated successfully');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return back()->with('success', 'Client deleted');
    }
}
