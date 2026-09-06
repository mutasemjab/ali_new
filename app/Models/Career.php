<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'title', 'description',
    ];

    public function specifications()
    {
        return $this->hasMany(CareerSpecification::class)->orderBy('id');
    }

    public function applies()
    {
        return $this->hasMany(CareerApply::class);
    }
}
