<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'name', 'phone', 'number_of_visit', 'total_points',
    ];
}
