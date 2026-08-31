<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoginRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show_login_view()
    {
        return view('store.auth.login');
    }

    public function login(StoreLoginRequest $request)
    {
        if (! auth()->guard('store')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->route('store.showlogin')->with('error', 'Invalid login credentials');
        }

        $store = auth()->guard('store')->user();

        if (! $store->isActive()) {
            auth()->guard('store')->logout();

            return redirect()->route('store.showlogin')->with('error', 'This store account has been suspended. Please contact support: 5594082282');
        }

        return redirect()->route('store.dashboard');
    }

    public function logout()
    {
        auth()->guard('store')->logout();

        return redirect()->route('store.showlogin');
    }

    public function editlogin($id)
    {
        $data = Store::findOrFail($id);

        return view('store.auth.edit', compact('data'));
    }

    public function updatelogin(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:stores,email,' . $id,
            'phone' => 'nullable|string|max:50|unique:stores,phone,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $store->update($data);

        return redirect()->route('store.dashboard')->with('success', 'Account details updated successfully');
    }
}
