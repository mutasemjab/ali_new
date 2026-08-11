<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'from_date', 'to_date', 'amount', 'note', 'payment_type',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
