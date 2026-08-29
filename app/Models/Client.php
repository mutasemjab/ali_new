<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory, HasApiTokens, BelongsToStore;

    protected $fillable = [
        'store_id', 'name', 'phone', 'email', 'fcm_token', 'number_of_visit', 'total_points',
    ];

    public function couponClients()
    {
        return $this->hasMany(CouponClient::class);
    }
}
