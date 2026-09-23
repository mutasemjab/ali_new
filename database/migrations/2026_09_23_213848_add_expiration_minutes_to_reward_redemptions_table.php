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
        Schema::table('reward_redemptions', function (Blueprint $table) {
            // Locked in at redemption time from the reward's current redeem_window_minutes,
            // so a later admin edit doesn't retroactively change a countdown already ticking
            // on a client's device — same reasoning as CouponClient.expiration_time.
            $table->unsignedInteger('expiration_minutes')->default(60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_redemptions', function (Blueprint $table) {
            $table->dropColumn('expiration_minutes');
        });
    }
};
