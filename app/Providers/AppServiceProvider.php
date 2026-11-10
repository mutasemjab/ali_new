<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Setting;
use App\Models\Store;
use App\Services\Sms\SmsGatewayInterface;
use App\Services\Sms\TwilioSmsGateway;
use Illuminate\Support\Facades\URL;
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

        // The store-site.* routes live under Route::domain('{subdomain}.'.rootHost), so
        // route()/URL calls to them need a "subdomain" value — without this default,
        // generating one of those links from a page already on that subdomain (e.g. the
        // nav/footer) would throw "Missing required parameter: subdomain".
        if ($slug = Store::subdomainSlugFromHost()) {
            URL::defaults(['subdomain' => $slug]);
        }
    }
}
