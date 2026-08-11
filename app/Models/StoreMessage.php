<?php

namespace App\Models;

use App\Models\Concerns\BelongsToStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreMessage extends Model
{
    use HasFactory, BelongsToStore;

    protected $fillable = [
        'store_id', 'content', 'recipients_count', 'sent_count', 'failed_count', 'status',
    ];

    public function recipients()
    {
        return $this->hasMany(StoreMessageRecipient::class);
    }
}
