<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            // Each store can run its own fully separate Twilio account (some stores already
            // own numbers under their own Twilio account, not the platform's shared one).
            // All three — sid, token, and the existing twilio_phone_number — are used
            // together as a set, or not at all (falls back to the shared .env credentials).
            $table->string('twilio_sid')->nullable()->after('twilio_phone_number');
            $table->text('twilio_auth_token')->nullable()->after('twilio_sid');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['twilio_sid', 'twilio_auth_token']);
        });
    }
};
