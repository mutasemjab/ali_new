<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientVisit extends Model
{
    protected $fillable = [
        'store_id', 'client_id', 'visit_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
