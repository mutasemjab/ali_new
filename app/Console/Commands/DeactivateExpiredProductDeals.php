<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class DeactivateExpiredProductDeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:deactivate-expired-deals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Turn OFF any product whose dated special-offer window has closed, across all stores';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = Product::deactivateExpiredDeals();

        $this->info("Deactivated {$count} expired-deal product(s).");

        return self::SUCCESS;
    }
}
