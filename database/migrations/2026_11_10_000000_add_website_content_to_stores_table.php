<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Content for this store's own public "website" (home hero + about), entered by the
     * store itself from its dashboard — mirrors the shape of LandingSetting, but per store.
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('hero_title')->nullable()->after('subdomain');
            $table->text('hero_subtitle')->nullable()->after('hero_title');
            $table->string('hero_image')->nullable()->after('hero_subtitle');
            $table->string('about_title')->nullable()->after('hero_image');
            $table->text('about_body')->nullable()->after('about_title');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['hero_title', 'hero_subtitle', 'hero_image', 'about_title', 'about_body']);
        });
    }
};
