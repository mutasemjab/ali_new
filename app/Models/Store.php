<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Store extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'photo', 'activate', 'total_sms',
        'privacy_policy', 'facebook_link',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'activate' => 'integer',
        'total_sms' => 'integer',
    ];

    public function isActive(): bool
    {
        return (int) $this->activate === 1;
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function messages()
    {
        return $this->hasMany(StoreMessage::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(StoreSubscription::class);
    }

    public function smsLedger()
    {
        return $this->hasMany(StoreSms::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
