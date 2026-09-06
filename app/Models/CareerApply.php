<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerApply extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'career_id', 'career_specification_id', 'value',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function specification()
    {
        return $this->belongsTo(CareerSpecification::class, 'career_specification_id');
    }
}
