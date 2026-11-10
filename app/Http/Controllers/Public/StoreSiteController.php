<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Store;
use Illuminate\Http\Request;

/**
 * A store's own "website" — reached on its subdomain (e.g. laesperanzamarket.flyerall.net)
 * and routed there via the Route::domain() group in routes/web.php. Reuses the FlyerAll
 * marketing site's layout/look, but every page here shows only this one store's own data —
 * never another store's, and never the generic FlyerAll platform content.
 */
class StoreSiteController extends Controller
{
    public function home()
    {
        $store = $this->currentStore();

        return view('landing.store-home', compact('store'));
    }

    public function about()
    {
        $store = $this->currentStore();

        return view('landing.store-about', compact('store'));
    }

    public function contact()
    {
        $store = $this->currentStore();

        return view('landing.store-contact', compact('store'));
    }

    public function storeFeedback(Request $request)
    {
        $store = $this->currentStore();

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

        return back()->with('success', 'Thanks! Your message has been sent to ' . $store->name . '.');
    }

    private function currentStore(): Store
    {
        $store = Store::resolveFromSubdomain();

        abort_if(! $store, 404);

        return $store;
    }
}
