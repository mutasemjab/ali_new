<?php

namespace App\Services\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TwilioSmsGateway implements SmsGatewayInterface
{
    protected Client $client;

    public function __construct(protected string $sid, protected string $token, protected string $from)
    {
        $this->client = new Client();
    }

    public function send(string $to, string $message): bool
    {
        try {
            $response = $this->client->post(
                "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json",
                [
                    'auth' => [$this->sid, $this->token],
                    'form_params' => [
                        'To' => $to,
                        'From' => $this->from,
                        'Body' => $message,
                    ],
                ]
            );

            return $response->getStatusCode() < 300;
        } catch (GuzzleException $e) {
            Log::error('Twilio SMS send failed', ['to' => $to, 'error' => $e->getMessage()]);

            return false;
        }
    }
}
