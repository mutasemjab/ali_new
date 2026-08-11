<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreMessageRecipient extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'store_message_id', 'client_id', 'phone', 'status', 'error', 'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function message()
    {
        return $this->belongsTo(StoreMessage::class, 'store_message_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
