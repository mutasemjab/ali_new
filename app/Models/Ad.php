<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ad extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'type', 'image', 'token', 'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (Ad $ad) {
            if (empty($ad->token)) {
                $ad->token = Str::random(32);
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getPublicUrlAttribute(): string
    {
        return route('public.ads.show', $this->token);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
