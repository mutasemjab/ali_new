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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->text('terms');
            $table->string('photo');
            $table->string('status')->default('clip');
            $table->string('save_price');
            $table->string('price');
            $table->string('price_after_discount');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('time_when_clipped');
            $table->string('barcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
