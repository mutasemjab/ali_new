<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'privacy_policy',
        'terms_of_service',
        'anti_spam_policy',
        'client_privacy_policy',
    ];

    /**
     * There's only ever one row — fetch it, creating it on first use.
     */
    public static function current(): self
    {
        return static::firstOrCreate([]);
    }
}
