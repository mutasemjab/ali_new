<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSms extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'type', 'quantity', 'balance_after', 'reference', 'note', 'created_by',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
