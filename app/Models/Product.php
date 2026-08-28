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
        'price_after', 'discount_from', 'discount_to', 'active', 'sort_order',
    ];

    protected $casts = [
        'price_usd' => 'decimal:2',
        'price_after' => 'decimal:2',
        'discount_from' => 'date',
        'discount_to' => 'date',
        'active' => 'boolean',
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
        if (empty($this->price_after) || (float) $this->price_after >= (float) $this->price_usd
            || ! $this->discount_from || ! $this->discount_to) {
            return false;
        }

        $today = now()->toDateString();

        return $today >= $this->discount_from->toDateString() && $today <= $this->discount_to->toDateString();
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->has_active_discount ? (float) $this->price_after : (float) $this->price_usd;
    }
}
