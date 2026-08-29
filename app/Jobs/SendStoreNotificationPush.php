<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\FCMController;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendStoreNotificationPush implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Notification $notification)
    {
    }

    public function handle()
    {
        $notification = $this->notification;

        $clients = Client::withoutGlobalScopes()
            ->where('store_id', $notification->store_id)
            ->whereNotNull('fcm_token')
            ->where('fcm_token', '!=', '')
            ->get();

        $sent = 0;
        $failed = 0;

        foreach ($clients as $client) {
            $ok = FCMController::sendToToken($notification->title, $notification->body, $client->fcm_token, 'notifications');

            $ok ? $sent++ : $failed++;
        }

        Log::info("Store notification #{$notification->id} pushed: {$sent} sent, {$failed} failed, " . $clients->count() . ' recipients');
    }
}
