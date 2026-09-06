<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSpecificationValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_specification_id', 'value',
    ];

    public function specification()
    {
        return $this->belongsTo(CareerSpecification::class, 'career_specification_id');
    }
}
