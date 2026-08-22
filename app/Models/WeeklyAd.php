<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyAd extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'photo', 'start_at', 'end_at',
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];
}
