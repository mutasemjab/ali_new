<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->string('price');
            $table->string('price_subtext')->nullable();
            $table->unsignedInteger('tablets_included')->default(0);
            $table->string('tablets_label')->nullable();
            $table->string('rate_text')->nullable();
            $table->string('color')->default('primary');
            $table->boolean('is_popular')->default(false);
            $table->string('badge_text')->nullable();
            $table->string('cta_text')->default('Get Started');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_plans');
    }
};
