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
        Schema::create('career_specifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('validation')->default('null');
            $table->tinyInteger('type')->default(1); // 1 text //2 select // 3 file
            $table->tinyInteger('available_report')->default(2); // 1 yes //2 no
            $table->unsignedBigInteger('career_id');
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
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
        Schema::dropIfExists('career_specifications');
    }
};
