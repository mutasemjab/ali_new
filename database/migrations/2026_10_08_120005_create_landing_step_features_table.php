<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_step_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_step_id')->constrained()->cascadeOnDelete();
            $table->string('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_step_features');
    }
};
