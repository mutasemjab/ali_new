<?php

namespace App\Services\Otp;

use App\Models\ClientOtp;
use App\Models\Store;
use App\Services\Sms\SmsGatewayInterface;

class OtpService
{
    protected const EXPIRY_MINUTES = 5;

    protected const RESEND_COOLDOWN_SECONDS = 60;

    public function __construct(protected SmsGatewayInterface $gateway)
    {
    }

    /**
     * Generates and sends a fresh OTP code for the given store/phone pair.
     * Returns false (without sending) if the caller must wait out the resend cooldown.
     */
    public function send(Store $store, string $phone): bool
    {
        $recent = ClientOtp::where('store_id', $store->id)
            ->where('phone', $phone)
            ->latest()
            ->first();

        if ($recent && $recent->created_at->gt(now()->subSeconds(self::RESEND_COOLDOWN_SECONDS))) {
            return false;
        }

        $code = (string) random_int(1000, 9999);

        ClientOtp::create([
            'store_id' => $store->id,
            'phone' => $phone,
            'code' => $code,
            'expires_at' => now()->addMinutes(self::EXPIRY_MINUTES),
        ]);

        $this->gateway->send($phone, "Your verification code is {$code}");

        return true;
    }

    public function verify(Store $store, string $phone, string $code): bool
    {
        $otp = ClientOtp::where('store_id', $store->id)
            ->where('phone', $phone)
            ->where('code', $code)
            ->whereNull('consumed_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $otp) {
            return false;
        }

        $otp->update(['consumed_at' => now()]);

        return true;
    }
}
