<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPlan extends Model
{
    protected $fillable = [
        'name', 'subtitle', 'price', 'price_subtext', 'tablets_included',
        'tablets_label', 'rate_text', 'color', 'is_popular', 'badge_text',
        'cta_text', 'sort_order',
    ];

    protected $casts = [
        'tablets_included' => 'integer',
        'is_popular' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function features()
    {
        return $this->hasMany(LandingPlanFeature::class)->orderBy('sort_order');
    }
}
