<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Banner;
use App\Models\Client;
use App\Models\ClientVisit;
use App\Models\Store;
use App\Models\WeeklyAd;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StoreController extends Controller
{
    /**
     * GET /api/v1/stores/{store}/home — client app home screen: store info + banners.
     */
    public function home(Store $store)
    {
        if ($store->activate !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Store not found',
                'data' => null,
            ], 404);
        }

        $banners = Banner::where('store_id', $store->id)->latest()->get(['id', 'photo']);

        return response()->json([
            'status' => true,
            'message' => 'Home data retrieved successfully',
            'data' => [
                'store' => $this->storeDetails($store),
                'banners' => $banners->map(fn (Banner $banner) => [
                    'id' => $banner->id,
                    'image' => $this->imageUrl($banner->photo),
                ]),
                'icons' => [
                    'in_store_deals' => (bool) $store->show_in_store_deals,
                    'social' => (bool) $store->show_social,
                    'qr' => (bool) $store->show_qr,
                    'weekly_ads' => (bool) $store->show_weekly_ads,
                    'coupons' => (bool) $store->show_coupons,
                    'location' => (bool) $store->show_location,
                    'rewards' => (bool) $store->show_rewards,
                ],
            ],
        ]);
    }

    /**
     * POST /api/v1/stores/{store}/verify-pin — tablet kiosk setup: confirm the PIN
     * an admin assigned to this store before letting the tablet remember/use it.
     */
    public function verifyPin(Request $request, Store $store)
    {
        $request->validate([
            'pin' => 'required|string',
        ]);

        if ($store->activate !== 1) {
            return response()->json(['status' => false, 'message' => 'Store not found', 'data' => null], 404);
        }

        if (empty($store->pin) || ! hash_equals((string) $store->pin, (string) $request->pin)) {
            return response()->json(['status' => false, 'message' => 'Incorrect PIN', 'data' => null], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'PIN verified successfully',
            'data' => ['store' => $this->storeDetails($store)],
        ]);
    }

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
     * GET /api/v1/stores/{store} — store info + its currently active weekly ads.
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

        $today = Carbon::today();

        $weeklyAds = WeeklyAd::where('store_id', $store->id)
            ->whereDate('start_at', '<=', $today)
            ->whereDate('end_at', '>=', $today)
            ->orderByDesc('start_at')
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'status' => true,
            'message' => 'Store retrieved successfully',
            'data' => [
                'store' => $this->storeDetails($store),
                'weekly_ads' => $weeklyAds->getCollection()->map(fn (WeeklyAd $weeklyAd) => $this->weeklyAdSummary($weeklyAd)),
            ],
            'pagination' => $this->paginationMeta($weeklyAds),
        ]);
    }

    /**
     * GET /api/v1/privacy-policy — the admin-managed privacy policy content (global, not per-store).
     */
    public function privacyPolicy()
    {
        return response()->json([
            'status' => true,
            'message' => 'Privacy policy retrieved successfully',
            'data' => [
                'content' => AppSetting::current()->privacy_policy,
            ],
        ]);
    }

    /**
     * GET /api/v1/stores/{store}/legal-document?type=privacy_policy|terms_of_service|anti_spam_policy
     */
    public function legalDocument(Request $request, Store $store)
    {
        if ($store->activate !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Store not found',
                'data' => null,
            ], 404);
        }

        $type = $request->query('type');

        $columns = ['privacy_policy', 'terms_of_service', 'anti_spam_policy'];

        if (! in_array($type, $columns, true)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid document type. Must be one of: '.implode(', ', $columns),
                'data' => null,
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Document retrieved successfully',
            'data' => [
                'content' => AppSetting::current()->{$type},
            ],
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
                'privacy_policy' => AppSetting::current()->privacy_policy,
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

        if (! $client->exists) {
            $client->number_of_visit = 0;
        }

        $client->save();

        // A "visit" only counts once per calendar day, regardless of how many
        // times this phone number is entered on the tablet that same day.
        $today = Carbon::today();

        $alreadyVisitedToday = ClientVisit::where('client_id', $client->id)
            ->whereDate('visit_date', $today)
            ->exists();

        if (! $alreadyVisitedToday) {
            ClientVisit::create([
                'store_id' => $store->id,
                'client_id' => $client->id,
                'visit_date' => $today,
            ]);

            $client->increment('number_of_visit');
        }

        return response()->json([
            'status' => true,
            'message' => 'You have been subscribed successfully',
            'data' => [
                'client_id' => $client->id,
                'store_id' => $store->id,
                'phone' => $client->phone,
                'number_of_visit' => $client->number_of_visit,
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

    private function weeklyAdSummary(WeeklyAd $weeklyAd): array
    {
        return [
            'id' => $weeklyAd->id,
            'image' => $this->imageUrl($weeklyAd->photo),
            'start_at' => $weeklyAd->start_at->toDateString(),
            'end_at' => $weeklyAd->end_at->toDateString(),
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
