<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WeeklyAd extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'photo', 'start_at', 'end_at', 'token',
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function (WeeklyAd $weeklyAd) {
            if (empty($weeklyAd->token)) {
                do {
                    $token = Str::random(8);
                } while (static::where('token', $token)->exists());

                $weeklyAd->token = $token;
            }
        });
    }

    public function getIsActiveAttribute(): bool
    {
        $today = now()->toDateString();

        return $today >= $this->start_at->toDateString() && $today <= $this->end_at->toDateString();
    }

    public function getPublicUrlAttribute(): string
    {
        return route('public.weekly-ads.show', $this->token);
    }
}
