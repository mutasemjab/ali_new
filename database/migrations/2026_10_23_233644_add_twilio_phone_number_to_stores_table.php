<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            // The Twilio number this store's SMS (campaigns + OTP) send from. When empty,
            // falls back to the platform's shared TWILIO_FROM number.
            $table->string('twilio_phone_number')->nullable()->after('pin');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('twilio_phone_number');
        });
    }
};
