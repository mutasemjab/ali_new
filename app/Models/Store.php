<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Store extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'photo', 'activate', 'total_sms',
        'privacy_policy', 'terms_of_service', 'anti_spam_policy', 'tablet_consent_text', 'facebook_link', 'pin',
        'twilio_phone_number', 'twilio_sid', 'twilio_auth_token', 'subdomain', 'points_per_visit',
        'show_in_store_deals', 'show_social', 'show_qr', 'show_weekly_ads',
        'show_coupons', 'show_location', 'show_rewards',
        'hero_title', 'hero_subtitle', 'hero_image', 'about_title', 'about_body',
    ];

    protected $hidden = ['password', 'twilio_auth_token'];

    protected $casts = [
        'activate' => 'integer',
        'total_sms' => 'integer',
        'points_per_visit' => 'integer',
        'twilio_auth_token' => 'encrypted',
        'show_in_store_deals' => 'boolean',
        'show_social' => 'boolean',
        'show_qr' => 'boolean',
        'show_weekly_ads' => 'boolean',
        'show_coupons' => 'boolean',
        'show_location' => 'boolean',
        'show_rewards' => 'boolean',
    ];

    /**
     * This store's own Twilio identity — sid, token, and from-number used together as one
     * set, never mixed with the platform's shared credentials or another store's number.
     * Returns [sid, token, from], each null when the store doesn't have its own full set
     * (falls back to the shared .env TWILIO_* credentials at the call site).
     */
    public function twilioCredentials(): array
    {
        if ($this->twilio_sid && $this->twilio_auth_token && $this->twilio_phone_number) {
            return [$this->twilio_sid, $this->twilio_auth_token, $this->twilio_phone_number];
        }

        return [null, null, null];
    }

    /**
     * This store's own subdomain base ("https://laesperanzamarket.flyerall.net"), used to
     * build its ad/weekly-ad public links. Null when the store has no subdomain configured
     * yet, so callers fall back to the normal shared-domain URL.
     */
    public function publicLinkBaseUrl(): ?string
    {
        if (empty($this->subdomain)) {
            return null;
        }

        $scheme = parse_url(config('app.url'), PHP_URL_SCHEME) ?: 'https';
        $host = parse_url(config('app.url'), PHP_URL_HOST) ?: config('app.url');

        return "{$scheme}://{$this->subdomain}.{$host}";
    }

    /**
     * The subdomain slug of the current request's host (e.g. "laesperanzamarket" for
     * "laesperanzamarket.flyerall.net"), with no lookup against the stores table. Null on
     * the root domain itself, or any host that isn't a direct subdomain of it.
     */
    public static function subdomainSlugFromHost(): ?string
    {
        $host = request()->getHost();
        $rootHost = parse_url(config('app.url'), PHP_URL_HOST) ?: '';

        if (empty($rootHost) || $host === $rootHost || ! str_ends_with($host, '.' . $rootHost)) {
            return null;
        }

        return substr($host, 0, -(strlen($rootHost) + 1));
    }

    /**
     * The store whose subdomain matches the current request's host (e.g. visiting
     * "laesperanzamarket.flyerall.net" resolves the "laesperanzamarket" store). Null when
     * the request is on the root domain or no store has claimed that subdomain.
     */
    public static function resolveFromSubdomain(): ?self
    {
        $slug = static::subdomainSlugFromHost();

        return $slug ? static::where('subdomain', $slug)->first() : null;
    }

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

    public function landingSteps()
    {
        return $this->hasMany(StoreLandingStep::class)->orderBy('sort_order');
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
