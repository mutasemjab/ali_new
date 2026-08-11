<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'name', 'phone', 'message',
    ];
}
