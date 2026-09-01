<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Ad extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'type', 'image', 'token', 'start_at', 'expires_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
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

    public function images()
    {
        return $this->hasMany(AdImage::class)->orderBy('id');
    }

    public function getPublicUrlAttribute(): string
    {
        return LaravelLocalization::getLocalizedURL('en', route('public.ads.show', $this->token));
    }

    public function getCoverImageAttribute(): ?string
    {
        return optional($this->images->first())->image ?? $this->image;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function getIsNotYetStartedAttribute(): bool
    {
        return $this->start_at !== null && $this->start_at->isFuture();
    }
}
