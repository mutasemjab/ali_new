<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * GET /api/v1/stores — pick-a-store screen.
     */
    public function index(Request $request)
    {
        $stores = Store::where('activate', 1)
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->orderBy('name')
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'status' => true,
            'message' => 'Stores retrieved successfully',
            'data' => $stores->getCollection()->map(fn (Store $store) => $this->storeSummary($store)),
            'pagination' => $this->paginationMeta($stores),
        ]);
    }

    /**
     * GET /api/v1/stores/{store} — store info + its products.
     */
    public function show(Request $request, Store $store)
    {
        if ($store->activate !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Store not found',
                'data' => null,
            ], 404);
        }

        $products = Product::with('category')
            ->where('store_id', $store->id)
            ->whereHas('category', fn ($q) => $q->where('active', true))
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->latest()
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'status' => true,
            'message' => 'Store retrieved successfully',
            'data' => [
                'store' => $this->storeDetails($store),
                'products' => $products->getCollection()->map(fn (Product $product) => $this->productSummary($product)),
            ],
            'pagination' => $this->paginationMeta($products),
        ]);
    }

    /**
     * GET /api/v1/stores/{store}/privacy
     */
    public function privacy(Store $store)
    {
        if ($store->activate !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Store not found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Privacy policy retrieved successfully',
            'data' => [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'privacy_policy' => $store->privacy_policy,
            ],
        ]);
    }

    /**
     * POST /api/v1/stores/{store}/subscribe — save the phone number entered on the tablet
     * as a Client of this store (opted in for SMS deals via the store's existing Messages feature).
     */
    public function subscribe(Request $request, Store $store)
    {
        if ($store->activate !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Store not found',
                'data' => null,
            ], 404);
        }

        $request->validate([
            'phone' => 'required|string|max:50',
            'name' => 'nullable|string|max:200',
        ]);

        $client = Client::firstOrNew([
            'store_id' => $store->id,
            'phone' => $request->phone,
        ]);

        $client->name = $request->name ?: $client->name ?: $request->phone;
        $client->number_of_visit = ($client->number_of_visit ?? 0) + 1;
        $client->save();

        return response()->json([
            'status' => true,
            'message' => 'You have been subscribed successfully',
            'data' => [
                'client_id' => $client->id,
                'store_id' => $store->id,
                'phone' => $client->phone,
            ],
        ]);
    }

    private function storeSummary(Store $store): array
    {
        return [
            'id' => $store->id,
            'name' => $store->name,
            'logo' => $this->imageUrl($store->photo),
        ];
    }

    private function storeDetails(Store $store): array
    {
        return [
            'id' => $store->id,
            'name' => $store->name,
            'logo' => $this->imageUrl($store->photo),
            'phone' => $store->phone,
            'facebook_link' => $store->facebook_link,
        ];
    }

    private function productSummary(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $this->imageUrl($product->image),
            'category' => $product->category?->name,
            'price_usd' => (float) $product->price_usd,
            'discount_percent' => (float) $product->discount_percent,
            'has_active_discount' => $product->has_active_discount,
            'final_price' => $product->final_price,
        ];
    }

    private function imageUrl(?string $path): ?string
    {
        return $path ? asset($path) : null;
    }

    private function paginationMeta($paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ];
    }
}
