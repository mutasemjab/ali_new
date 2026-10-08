<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingStep extends Model
{
    protected $fillable = [
        'number', 'title', 'description', 'image', 'color', 'sort_order',
    ];

    protected $casts = [
        'number' => 'integer',
        'sort_order' => 'integer',
    ];

    public function features()
    {
        return $this->hasMany(LandingStepFeature::class)->orderBy('sort_order');
    }
}
