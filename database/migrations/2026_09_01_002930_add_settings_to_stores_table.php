<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('pin', 10)->nullable()->after('activate');

            $table->boolean('show_in_store_deals')->default(true)->after('pin');
            $table->boolean('show_social')->default(true)->after('show_in_store_deals');
            $table->boolean('show_qr')->default(true)->after('show_social');
            $table->boolean('show_weekly_ads')->default(true)->after('show_qr');
            $table->boolean('show_coupons')->default(true)->after('show_weekly_ads');
            $table->boolean('show_location')->default(true)->after('show_coupons');
            $table->boolean('show_rewards')->default(true)->after('show_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'pin', 'show_in_store_deals', 'show_social', 'show_qr',
                'show_weekly_ads', 'show_coupons', 'show_location', 'show_rewards',
            ]);
        });
    }
};
