<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardRedemption extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'client_id', 'reward_product_id', 'points_spent',
    ];

    protected $casts = [
        'points_spent' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function rewardProduct()
    {
        return $this->belongsTo(RewardProduct::class);
    }
}
