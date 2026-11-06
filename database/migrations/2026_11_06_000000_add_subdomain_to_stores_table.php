<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Each store's own subdomain (e.g. "laesperanzamarket" -> laesperanzamarket.flyerall.net)
     * used for its ad/weekly-ad SMS links, so carriers see a distinct, store-specific domain
     * per sender instead of every store sharing the exact same flyerall.net/ads/... pattern.
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('subdomain')->nullable()->unique()->after('twilio_auth_token');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('subdomain');
        });
    }
};
