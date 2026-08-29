<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Store;
use App\Services\Otp\OtpService;
use Illuminate\Http\Request;

class ClientAuthController extends Controller
{
    public function __construct(protected OtpService $otp)
    {
    }

    /**
     * POST /stores/{store}/auth/register — creates the client record, then sends
     * an OTP. The account isn't usable (no token issued) until verify-otp succeeds.
     */
    public function register(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'nullable|email|max:200',
            'phone' => 'required|string|max:50',
            'fcm_token' => 'nullable|string|max:255',
        ]);

        $exists = Client::where('store_id', $store->id)->where('phone', $request->phone)->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'This phone number is already registered. Please login instead.',
                'data' => null,
            ], 422);
        }

        Client::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'fcm_token' => $request->fcm_token,
        ]);

        return $this->sendOtpResponse($store, $request->phone);
    }

    /**
     * POST /stores/{store}/auth/login — sends an OTP to an already-registered phone.
     */
    public function login(Request $request, Store $store)
    {
        $request->validate([
            'phone' => 'required|string|max:50',
        ]);

        $client = Client::where('store_id', $store->id)->where('phone', $request->phone)->first();

        if (! $client) {
            return response()->json([
                'status' => false,
                'message' => 'No account found with this phone number. Please register first.',
                'data' => null,
            ], 404);
        }

        return $this->sendOtpResponse($store, $request->phone);
    }

    /**
     * POST /stores/{store}/auth/resend-otp
     */
    public function resendOtp(Request $request, Store $store)
    {
        $request->validate([
            'phone' => 'required|string|max:50',
        ]);

        $exists = Client::where('store_id', $store->id)->where('phone', $request->phone)->exists();

        if (! $exists) {
            return response()->json([
                'status' => false,
                'message' => 'No account found with this phone number.',
                'data' => null,
            ], 404);
        }

        return $this->sendOtpResponse($store, $request->phone);
    }

    /**
     * POST /stores/{store}/auth/verify-otp — completes register or login, issues a Bearer token.
     */
    public function verifyOtp(Request $request, Store $store)
    {
        $request->validate([
            'phone' => 'required|string|max:50',
            'code' => 'required|string|max:6',
            'fcm_token' => 'nullable|string|max:255',
        ]);

        if (! $this->otp->verify($store, $request->phone, $request->code)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired verification code',
                'data' => null,
            ], 422);
        }

        $client = Client::where('store_id', $store->id)->where('phone', $request->phone)->firstOrFail();
        $client->increment('number_of_visit');

        if ($request->filled('fcm_token')) {
            $client->update(['fcm_token' => $request->fcm_token]);
        }

        $token = $client->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Verified successfully',
            'data' => [
                'token' => $token,
                'client' => $this->clientSummary($client),
            ],
        ]);
    }

    /**
     * POST /auth/logout (auth:sanctum)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
            'data' => null,
        ]);
    }

    private function sendOtpResponse(Store $store, string $phone)
    {
        if (! $this->otp->send($store, $phone)) {
            return response()->json([
                'status' => false,
                'message' => 'Please wait a moment before requesting another code',
                'data' => null,
            ], 429);
        }

        return response()->json([
            'status' => true,
            'message' => 'Verification code sent',
            'data' => ['phone' => $phone],
        ]);
    }

    private function clientSummary(Client $client): array
    {
        return [
            'id' => $client->id,
            'name' => $client->name,
            'phone' => $client->phone,
            'email' => $client->email,
            'number_of_visit' => $client->number_of_visit,
            'total_points' => $client->total_points,
        ];
    }
}
