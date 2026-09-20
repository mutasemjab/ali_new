<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory, HasApiTokens, BelongsToStore;

    protected $fillable = [
        'store_id', 'name', 'phone', 'email', 'fcm_token', 'number_of_visit', 'total_points',
    ];

    /**
     * Tablet numbers arrive without a country code while the app stores them as
     * "+1XXXXXXXXXX" — normalize so both resolve to the same client.
     */
    public static function normalizePhone(string $phone): string
    {
        $phone = trim($phone);
        $digits = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($phone, '+')) {
            return '+'.$digits;
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '1')) {
            return '+'.$digits;
        }

        return '+1'.$digits;
    }

    public function couponClients()
    {
        return $this->hasMany(CouponClient::class);
    }

    public function careerApplies()
    {
        return $this->hasMany(CareerApply::class);
    }

    public function rewardRedemptions()
    {
        return $this->hasMany(RewardRedemption::class);
    }
}
