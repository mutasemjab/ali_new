<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'category_id', 'name', 'image', 'price_usd',
        'discount_percent', 'discount_from', 'discount_to',
    ];

    protected $casts = [
        'price_usd' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_from' => 'date',
        'discount_to' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ads()
    {
        return $this->belongsToMany(Ad::class);
    }

    public function getHasActiveDiscountAttribute(): bool
    {
        if ($this->discount_percent <= 0 || ! $this->discount_from || ! $this->discount_to) {
            return false;
        }

        $today = now()->toDateString();

        return $today >= $this->discount_from->toDateString() && $today <= $this->discount_to->toDateString();
    }

    public function getFinalPriceAttribute(): float
    {
        if (! $this->has_active_discount) {
            return (float) $this->price_usd;
        }

        return round((float) $this->price_usd - ((float) $this->price_usd * (float) $this->discount_percent / 100), 2);
    }
}
