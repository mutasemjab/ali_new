<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardProduct extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'name', 'image', 'points_required', 'barcode',
    ];

    protected $casts = [
        'points_required' => 'integer',
    ];

    public function redemptions()
    {
        return $this->hasMany(RewardRedemption::class);
    }
}
