<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        // Existing values were free text (e.g. "7 days") — not meaningfully convertible to a
        // minute count, so reset to a sane default before the column becomes numeric.
        DB::table('coupons')->update(['time_when_clipped' => '20']);

        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedInteger('time_when_clipped')->default(20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('time_when_clipped')->default('20')->change();
        });
    }
};
