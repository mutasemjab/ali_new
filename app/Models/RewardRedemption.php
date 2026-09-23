<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardRedemption extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'client_id', 'reward_product_id', 'points_spent', 'expiration_minutes',
    ];

    protected $casts = [
        'points_spent' => 'integer',
        'expiration_minutes' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function rewardProduct()
    {
        return $this->belongsTo(RewardProduct::class);
    }

    /**
     * Minutes left before this redemption's barcode expires — recomputed from the
     * server's current time on every access, same as CouponClient's expires_at logic.
     */
    public function getMinutesRemainingAttribute(): int
    {
        return max(0, $this->expiration_minutes - $this->created_at->diffInMinutes(now()));
    }
}
