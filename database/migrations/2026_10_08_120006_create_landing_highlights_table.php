<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_highlights', function (Blueprint $table) {
            $table->id();
            // 'home_hero' = the 4 small badges under the Home hero.
            // 'plans_footer' = the 4 bigger feature cards at the bottom of the Plans page.
            $table->string('section');
            $table->string('icon')->default('bi-star');
            $table->string('color')->default('primary');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_highlights');
    }
};
