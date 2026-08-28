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
        Schema::create('ad_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->timestamps();
        });

        // Backfill: move each existing single-image ad's photo into the new table
        // so old ads keep working once the app reads from the `images` relation.
        DB::table('ads')
            ->where('type', 'image')
            ->whereNotNull('image')
            ->orderBy('id')
            ->get(['id', 'image'])
            ->each(function ($ad) {
                DB::table('ad_images')->insert([
                    'ad_id' => $ad->id,
                    'image' => $ad->image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_images');
    }
};
