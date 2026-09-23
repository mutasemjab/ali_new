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
        Schema::table('reward_products', function (Blueprint $table) {
            // How long a redemption's barcode stays valid, in minutes — same idea as
            // the coupon's "Time When Clipped" field, configurable per reward.
            $table->unsignedInteger('redeem_window_minutes')->default(60)->after('barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_products', function (Blueprint $table) {
            $table->dropColumn('redeem_window_minutes');
        });
    }
};
