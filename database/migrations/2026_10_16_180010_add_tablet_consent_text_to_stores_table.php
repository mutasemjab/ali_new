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
        Schema::table('stores', function (Blueprint $table) {
            // The short consent blurb shown on the tablet's "Review & Agree" screen —
            // separate from the full privacy_policy/terms_of_service/anti_spam_policy pages.
            $table->text('tablet_consent_text')->nullable()->after('anti_spam_policy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('tablet_consent_text');
        });
    }
};
