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
        Schema::table('coupons', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('barcode');
        });

        // Backfill: give every existing coupon a dense 1..N position within its own
        // store, ordered by id, so the new manual-ordering feature starts sane.
        DB::table('coupons')
            ->select('id', 'store_id')
            ->orderBy('store_id')
            ->orderBy('id')
            ->get()
            ->groupBy('store_id')
            ->each(function ($couponsInStore) {
                $position = 1;
                foreach ($couponsInStore as $coupon) {
                    DB::table('coupons')->where('id', $coupon->id)->update(['sort_order' => $position]);
                    $position++;
                }
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
            $table->dropColumn('sort_order');
        });
    }
};
