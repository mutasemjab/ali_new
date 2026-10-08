<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingStepFeature extends Model
{
    protected $fillable = [
        'landing_step_id', 'text', 'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function step()
    {
        return $this->belongsTo(LandingStep::class, 'landing_step_id');
    }
}
