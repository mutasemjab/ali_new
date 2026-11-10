<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A store's own "How It Works" steps — shown both embedded on its website's Home page
     * and on its standalone How It Works page. Mirrors landing_steps, but per store and
     * without the admin-only color/features-checklist richness (title+description+image).
     */
    public function up()
    {
        Schema::create('store_landing_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_landing_steps');
    }
};
