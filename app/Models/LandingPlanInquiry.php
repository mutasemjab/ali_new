<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPlanInquiry extends Model
{
    protected $fillable = [
        'landing_plan_id', 'plan_name', 'name', 'company', 'email', 'phone', 'message', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function plan()
    {
        return $this->belongsTo(LandingPlan::class, 'landing_plan_id');
    }
}
