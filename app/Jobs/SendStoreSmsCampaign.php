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
        $sentCount = 0;
        $failedCount = 0;

        foreach ($storeMessage->recipients()->withoutGlobalScopes()->get() as $recipient) {
            $ok = $gateway->send($recipient->phone, $storeMessage->content);

            $recipient->update([
                'status' => $ok ? 'sent' : 'failed',
                'sent_at' => $ok ? now() : null,
            ]);

            $ok ? $sentCount++ : $failedCount++;
        }

        $storeMessage->update([
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
            'status' => $failedCount === 0 ? 'sent' : ($sentCount === 0 ? 'failed' : 'sent'),
        ]);

        if ($sentCount > 0 && $store) {
            $balanceAfter = max(0, $store->total_sms - $sentCount);

            StoreSms::create([
                'store_id' => $store->id,
                'type' => 'send',
                'quantity' => -$sentCount,
                'balance_after' => $balanceAfter,
                'reference' => 'store_message:' . $storeMessage->id,
            ]);

            $store->update(['total_sms' => $balanceAfter]);
        }
    }
}
