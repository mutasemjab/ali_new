<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingContactMessage extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'message',
        'consent_non_marketing', 'consent_marketing', 'consent_terms', 'is_read',
    ];

    protected $casts = [
        'consent_non_marketing' => 'boolean',
        'consent_marketing' => 'boolean',
        'consent_terms' => 'boolean',
        'is_read' => 'boolean',
    ];
}
