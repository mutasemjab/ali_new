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
        if (empty($this->price_after) || ! $this->discount_from || ! $this->discount_to) {
            return false;
        }

        $today = now()->toDateString();

        return $today >= $this->discount_from->toDateString() && $today <= $this->discount_to->toDateString();
    }

    public function getFinalPriceAttribute(): string
    {
        return $this->has_active_discount ? $this->price_after : $this->price_usd;
    }

    /**
     * A dated special-offer product whose window has closed. Once true, it should stop
     * showing to customers — but stays untouched in the store panel so it can be reused
     * for a future offer by just setting new dates.
     */
    public function getIsExpiredDealAttribute(): bool
    {
        return $this->discount_to && now()->toDateString() > $this->discount_to->toDateString();
    }

    /**
     * Excludes expired dated special offers from a product listing, without touching
     * products that were never dated in the first place.
     */
    public function scopeNotExpiredDeal($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('discount_to')
                ->orWhereDate('discount_to', '>=', now()->toDateString());
        });
    }

    /**
     * Flips the ON/OFF switch itself to OFF for any still-active product whose dated
     * offer has closed, so the store panel reflects it, not just query-time filtering.
     * Safe to call often — only touches rows that actually need it. Returns how many
     * were flipped.
     *
     * Pass $storeId when calling from a context with no tenant bound (e.g. the mobile
     * API) to avoid sweeping every store's products on every request. Omit it inside
     * the store panel, where the tenant global scope already restricts it for you,
     * or from a scheduled command, where sweeping every store is exactly the point.
     */
    public static function deactivateExpiredDeals(?int $storeId = null): int
    {
        return static::when($storeId, fn ($q) => $q->where('store_id', $storeId))
            ->where('active', true)
            ->whereNotNull('discount_to')
            ->whereDate('discount_to', '<', now()->toDateString())
            ->update(['active' => false]);
    }
}
