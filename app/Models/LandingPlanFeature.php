<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPlanFeature extends Model
{
    protected $fillable = [
        'landing_plan_id', 'text', 'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function plan()
    {
        return $this->belongsTo(LandingPlan::class, 'landing_plan_id');
    }
}
