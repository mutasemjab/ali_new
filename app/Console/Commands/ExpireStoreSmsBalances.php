<?php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\StoreSms;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireStoreSmsBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:expire-balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Zero out a store\'s SMS balance once 30 days have passed since its last recharge';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredCount = 0;

        Store::where('total_sms', '>', 0)->chunkById(100, function ($stores) use (&$expiredCount) {
            foreach ($stores as $store) {
                $lastRecharge = $store->smsLedger()
                    ->where('type', 'recharge')
                    ->latest()
                    ->first();

                if (! $lastRecharge || $lastRecharge->created_at->gt(Carbon::now()->subDays(30))) {
                    continue;
                }

                StoreSms::create([
                    'store_id' => $store->id,
                    'type' => 'expired',
                    'quantity' => -$store->total_sms,
                    'balance_after' => 0,
                    'note' => 'SMS balance expired 30 days after last recharge',
                ]);

                $store->update(['total_sms' => 0]);

                $expiredCount++;
            }
        });

        $this->info("Expired SMS balance for {$expiredCount} store(s).");

        return self::SUCCESS;
    }
}
