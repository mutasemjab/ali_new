<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::when($request->search, fn ($q, $s) => $q->where(fn ($q2) => $q2
                ->where('name', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%")
                ->orWhere('phone', 'like', "%$s%")
            ))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:stores,email',
            'phone' => 'nullable|string|max:50|unique:stores,phone',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = $request->hasFile('photo')
            ? 'assets/uploads/stores/' . uploadImage('assets/uploads/stores', $request->file('photo'))
            : 'assets/uploads/stores/default.png';

        Store::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'photo' => $photoPath,
            'activate' => 1,
            'total_sms' => 0,
        ]);

        return redirect()->route('admin.stores.index')->with('success', 'Store created successfully');
    }

    public function show(Store $store)
    {
        $store->load(['subscriptions' => fn ($q) => $q->latest('to_date'), 'smsLedger' => fn ($q) => $q->latest()]);
        $clientsCount = $store->clients()->count();

        return view('admin.stores.show', compact('store', 'clientsCount'));
    }

    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:stores,email,' . $store->id,
            'phone' => 'nullable|string|max:50|unique:stores,phone,' . $store->id,
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = 'assets/uploads/stores/' . uploadImage('assets/uploads/stores', $request->file('photo'));
        }

        $store->update($data);

        return redirect()->route('admin.stores.index')->with('success', 'Store updated successfully');
    }

    public function toggle(Store $store)
    {
        $store->update(['activate' => $store->activate === 1 ? 2 : 1]);

        return back()->with('success', $store->activate === 1 ? 'Store activated' : 'Store suspended');
    }

    public function destroy(Store $store)
    {
        $store->delete();

        return back()->with('success', 'Store deleted');
    }
}
