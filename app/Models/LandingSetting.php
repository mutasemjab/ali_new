<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingSetting extends Model
{
    protected $fillable = [
        'hero_title', 'hero_subtitle', 'hero_image_home', 'hero_image_plans',
        'monthly_fee_amount', 'monthly_fee_label', 'redeem_banner_text',
        'cta_text', 'cta_url', 'about_title', 'about_body',
        'contact_email', 'contact_phone', 'contact_address',
    ];

    /**
     * There's only ever one row — fetch it, creating it on first use.
     */
    public static function current(): self
    {
        return static::firstOrCreate([]);
    }
}
