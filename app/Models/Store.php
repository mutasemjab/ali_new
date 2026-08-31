<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Store extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'photo', 'activate', 'total_sms',
        'privacy_policy', 'facebook_link', 'pin',
        'show_in_store_deals', 'show_social', 'show_qr', 'show_weekly_ads',
        'show_coupons', 'show_location', 'show_rewards',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'activate' => 'integer',
        'total_sms' => 'integer',
        'show_in_store_deals' => 'boolean',
        'show_social' => 'boolean',
        'show_qr' => 'boolean',
        'show_weekly_ads' => 'boolean',
        'show_coupons' => 'boolean',
        'show_location' => 'boolean',
        'show_rewards' => 'boolean',
    ];

    public function isActive(): bool
    {
        return (int) $this->activate === 1;
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function messages()
    {
        return $this->hasMany(StoreMessage::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(StoreSubscription::class);
    }

    public function smsLedger()
    {
        return $this->hasMany(StoreSms::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    public function weeklyAds()
    {
        return $this->hasMany(WeeklyAd::class);
    }

    public function socials()
    {
        return $this->hasMany(Social::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function qrs()
    {
        return $this->hasMany(Qr::class);
    }

    public function couponClients()
    {
        return $this->hasMany(CouponClient::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function rewardProducts()
    {
        return $this->hasMany(RewardProduct::class);
    }
}
