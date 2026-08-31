<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'name', 'description', 'terms', 'photo', 'status',
        'save_price', 'price', 'price_after_discount', 'start_at', 'end_at',
        'time_when_clipped', 'barcode',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function couponClients()
    {
        return $this->hasMany(CouponClient::class);
    }

    public function getIsActiveAttribute(): bool
    {
        $now = now();

        return $now->gte($this->start_at) && $now->lte($this->end_at);
    }
}
