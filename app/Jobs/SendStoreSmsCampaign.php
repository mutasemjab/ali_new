<?php

namespace App\Jobs;

use App\Models\StoreMessage;
use App\Models\StoreSms;
use App\Services\Sms\SmsGatewayInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendStoreSmsCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected StoreMessage $storeMessage)
    {
    }

    public function handle(SmsGatewayInterface $gateway)
    {
        $storeMessage = $this->storeMessage;
        $storeMessage->update(['status' => 'sending']);

        $store = $storeMessage->store()->withoutGlobalScopes()->first();
        [$twilioSid, $twilioToken, $twilioFrom] = $store?->twilioCredentials() ?? [null, null, null];

        // Created up front and updated after every single send (not once at the end) —
        // so if this run gets interrupted partway through (timeout, worker restart), the
        // store's balance still accurately reflects exactly what was actually sent so far.
        $ledger = $store ? StoreSms::create([
            'store_id' => $store->id,
            'type' => 'send',
            'quantity' => 0,
            'balance_after' => $store->total_sms,
            'reference' => 'store_message:' . $storeMessage->id,
        ]) : null;

        $sentCount = 0;
        $failedCount = 0;

        foreach ($storeMessage->recipients()->withoutGlobalScopes()->get() as $recipient) {
            $ok = $gateway->send($recipient->phone, $storeMessage->content, $twilioFrom, $twilioSid, $twilioToken);

            $recipient->update([
                'status' => $ok ? 'sent' : 'failed',
                'sent_at' => $ok ? now() : null,
            ]);

            if ($ok) {
                $sentCount++;

                if ($store) {
                    $store->total_sms = max(0, $store->total_sms - 1);
                    $store->save();

                    $ledger->update([
                        'quantity' => $ledger->quantity - 1,
                        'balance_after' => $store->total_sms,
                    ]);
                }
            } else {
                $failedCount++;
            }
        }

        $storeMessage->update([
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
            'status' => $failedCount === 0 ? 'sent' : ($sentCount === 0 ? 'failed' : 'sent'),
        ]);
    }
}
