<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Setting;
use App\Services\Sms\SmsGatewayInterface;
use App\Services\Sms\TwilioSmsGateway;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SmsGatewayInterface::class, function () {
            return new TwilioSmsGateway(
                config('services.twilio.sid'),
                config('services.twilio.token'),
                config('services.twilio.from'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::USeBootstrap();
   
    }
}
