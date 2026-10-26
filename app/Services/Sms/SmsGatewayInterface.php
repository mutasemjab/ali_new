<?php

namespace App\Services\Sms;

interface SmsGatewayInterface
{
    /**
     * @param  string|null  $from   Overrides the default sending number (e.g. a store's own
     *                              Twilio number). Null uses the default.
     * @param  string|null  $sid    Overrides the Twilio Account SID to authenticate as
     *                              (e.g. a store's own Twilio account). Null uses the default.
     * @param  string|null  $token  Overrides the Twilio Auth Token to match $sid. Null uses the default.
     */
    public function send(string $to, string $message, ?string $from = null, ?string $sid = null, ?string $token = null): bool;
}
