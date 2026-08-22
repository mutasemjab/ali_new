<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponClient extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'client_id', 'coupon_id', 'clipped_at', 'expiration_time', 'status',
    ];

    protected $casts = [
        'clipped_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
