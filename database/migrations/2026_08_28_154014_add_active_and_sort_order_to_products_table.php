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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('discount_to');
            $table->integer('sort_order')->default(0)->after('active');
        });

        // Backfill: give every existing product a dense 1..N position within its own store,
        // ordered by id, so the new manual-ordering feature starts from a sane state.
        DB::table('products')
            ->select('id', 'store_id')
            ->orderBy('store_id')
            ->orderBy('id')
            ->get()
            ->groupBy('store_id')
            ->each(function ($productsInStore) {
                $position = 1;
                foreach ($productsInStore as $product) {
                    DB::table('products')->where('id', $product->id)->update(['sort_order' => $position]);
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['active', 'sort_order']);
        });
    }
};
