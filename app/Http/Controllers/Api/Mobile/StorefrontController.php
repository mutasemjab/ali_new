<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\CouponClient;
use App\Models\Location;
use App\Models\Product;
use App\Models\Qr;
use App\Models\RewardProduct;
use App\Models\Social;
use App\Models\Store;
use App\Models\WeeklyAd;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class StorefrontController extends Controller
{
    /**
     * GET /stores/{store}/categories
     */
    public function categories(Store $store)
    {
        $categories = Category::where('store_id', $store->id)
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories,
        ]);
    }

    /**
     * GET /stores/{store}/products — optional ?category_id= to filter, omitted = all.
     */
    public function products(Request $request, Store $store)
    {
        $products = Product::with('category')
            ->where('store_id', $store->id)
            ->where('active', true)
            ->when($request->category_id, fn ($q, $categoryId) => $q->where('category_id', $categoryId))
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->orderBy('sort_order')
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products->getCollection()->map(fn (Product $product) => $this->productSummary($product)),
            'pagination' => $this->paginationMeta($products),
        ]);
    }

    /**
     * GET /stores/{store}/socials
     */
    public function socials(Store $store)
    {
        $socials = Social::where('store_id', $store->id)->get(['id', 'name', 'photo', 'link']);

        return response()->json([
            'status' => true,
            'message' => 'Social links retrieved successfully',
            'data' => $socials->map(fn (Social $social) => [
                'id' => $social->id,
                'name' => $social->name,
                'icon' => $this->imageUrl($social->photo),
                'link' => $social->link,
            ]),
        ]);
    }

    /**
     * GET /stores/{store}/qrs
     */
    public function qrs(Store $store)
    {
        $qrs = Qr::where('store_id', $store->id)->latest()->get(['id', 'photo', 'link']);

        return response()->json([
            'status' => true,
            'message' => 'QR codes retrieved successfully',
            'data' => $qrs->map(fn (Qr $qr) => [
                'id' => $qr->id,
                'image' => $this->imageUrl($qr->photo),
                'link' => $qr->link,
            ]),
        ]);
    }

    /**
     * GET /stores/{store}/weekly-ads — only currently active ones.
     */
    public function weeklyAds(Store $store)
    {
        $today = Carbon::today();

        $weeklyAds = WeeklyAd::where('store_id', $store->id)
            ->whereDate('start_at', '<=', $today)
            ->whereDate('end_at', '>=', $today)
            ->orderByDesc('start_at')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Weekly ads retrieved successfully',
            'data' => $weeklyAds->map(fn (WeeklyAd $weeklyAd) => [
                'id' => $weeklyAd->id,
                'image' => $this->imageUrl($weeklyAd->photo),
                'start_at' => $weeklyAd->start_at->toDateString(),
                'end_at' => $weeklyAd->end_at->toDateString(),
            ]),
        ]);
    }

    /**
     * GET /stores/{store}/locations
     */
    public function locations(Store $store)
    {
        $locations = Location::where('store_id', $store->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Locations retrieved successfully',
            'data' => $locations->map(fn (Location $location) => [
                'id' => $location->id,
                'name' => $location->name,
                'address' => $location->address,
                'photo' => $this->imageUrl($location->photo),
                'lat' => (float) $location->lat,
                'lng' => (float) $location->lng,
                'phone' => $location->phone,
            ]),
        ]);
    }

    /**
     * GET /stores/{store}/coupons — currently valid coupons. Auth is optional: if a
     * Bearer token is present, each coupon is flagged with whether this client already clipped it.
     */
    public function coupons(Request $request, Store $store)
    {
        $today = now();

        $coupons = Coupon::where('store_id', $store->id)
            ->where('start_at', '<=', $today)
            ->where('end_at', '>=', $today)
            ->orderBy('end_at')
            ->get();

        $client = $this->resolveOptionalClient($request);

        $clippedCouponIds = $client
            ? CouponClient::where('client_id', $client->id)->pluck('coupon_id')->all()
            : [];

        return response()->json([
            'status' => true,
            'message' => 'Coupons retrieved successfully',
            'data' => $coupons->map(fn (Coupon $coupon) => $this->couponSummary($coupon, in_array($coupon->id, $clippedCouponIds))),
        ]);
    }

    /**
     * POST /stores/{store}/coupons/{coupon}/clip (auth:sanctum)
     */
    public function clipCoupon(Request $request, Store $store, Coupon $coupon)
    {
        if ((int) $coupon->store_id !== (int) $store->id) {
            return response()->json(['status' => false, 'message' => 'Coupon not found', 'data' => null], 404);
        }

        $client = $request->user();

        $couponClient = CouponClient::firstOrNew([
            'store_id' => $store->id,
            'client_id' => $client->id,
            'coupon_id' => $coupon->id,
        ]);

        $alreadyClipped = $couponClient->exists;

        if (! $alreadyClipped) {
            $couponClient->status = 'clipped';
            $couponClient->clipped_at = now();
            $couponClient->save();
        }

        return response()->json([
            'status' => true,
            'message' => $alreadyClipped ? 'Coupon already clipped' : 'Coupon clipped successfully',
            'data' => $this->couponSummary($coupon, true, $couponClient),
        ]);
    }

    /**
     * GET /stores/{store}/rewards — every reward tier, plus this client's progress
     * toward each one (either via Bearer token, or ?phone= for the tablet kiosk flow).
     */
    public function rewards(Request $request, Store $store)
    {
        $rewardProducts = RewardProduct::where('store_id', $store->id)
            ->orderBy('visits_required')
            ->get();

        $client = $this->resolveOptionalClient($request);

        if (! $client && $request->filled('phone')) {
            $client = Client::where('store_id', $store->id)->where('phone', $request->phone)->first();
        }

        $currentVisits = $client->number_of_visit ?? 0;

        return response()->json([
            'status' => true,
            'message' => 'Rewards retrieved successfully',
            'data' => [
                'current_visits' => $currentVisits,
                'rewards' => $rewardProducts->map(fn (RewardProduct $rewardProduct) => [
                    'id' => $rewardProduct->id,
                    'name' => $rewardProduct->name,
                    'image' => $this->imageUrl($rewardProduct->image),
                    'visits_required' => $rewardProduct->visits_required,
                    'earned' => $currentVisits >= $rewardProduct->visits_required,
                    'visits_remaining' => max(0, $rewardProduct->visits_required - $currentVisits),
                ])->values(),
            ],
        ]);
    }

    /**
     * GET /me/coupons (auth:sanctum) — this client's clipped coupons.
     */
    public function myCoupons(Request $request)
    {
        $client = $request->user();

        $clipped = CouponClient::with('coupon')
            ->where('client_id', $client->id)
            ->latest()
            ->get()
            ->filter(fn (CouponClient $couponClient) => $couponClient->coupon !== null);

        return response()->json([
            'status' => true,
            'message' => 'Clipped coupons retrieved successfully',
            'data' => $clipped->map(fn (CouponClient $couponClient) => $this->couponSummary($couponClient->coupon, true, $couponClient))->values(),
        ]);
    }

    private function resolveOptionalClient(Request $request)
    {
        $token = $request->bearerToken();

        if (! $token) {
            return null;
        }

        return optional(PersonalAccessToken::findToken($token))->tokenable;
    }

    private function couponSummary(Coupon $coupon, bool $clipped, ?CouponClient $couponClient = null): array
    {
        return [
            'id' => $coupon->id,
            'name' => $coupon->name,
            'description' => $coupon->description,
            'terms' => $coupon->terms,
            'photo' => $this->imageUrl($coupon->photo),
            'price' => $coupon->price,
            'price_after_discount' => $coupon->price_after_discount,
            'save_price' => $coupon->save_price,
            'start_at' => $coupon->start_at->toDateTimeString(),
            'end_at' => $coupon->end_at->toDateTimeString(),
            'time_when_clipped' => $coupon->time_when_clipped,
            'barcode' => $coupon->barcode,
            'is_clipped' => $clipped,
            'clipped_at' => optional($couponClient?->clipped_at)->toDateTimeString(),
        ];
    }

    private function productSummary(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $this->imageUrl($product->image),
            'category' => $product->category?->name,
            'category_id' => $product->category_id,
            'price_usd' => $product->price_usd,
            'price_after' => $product->price_after,
            'has_active_discount' => $product->has_active_discount,
            'discount_from' => $product->discount_from,
            'discount_to' => $product->discount_to,
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
