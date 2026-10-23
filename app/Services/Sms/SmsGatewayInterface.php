<?php

namespace App\Services\Sms;

interface SmsGatewayInterface
{
    /**
     * @param  string|null  $from  Overrides the gateway's default sending number
     *                             (e.g. a store's own Twilio number). Null uses the default.
     */
    public function send(string $to, string $message, ?string $from = null): bool;
}
