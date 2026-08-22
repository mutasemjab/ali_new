<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE store_sms MODIFY COLUMN type ENUM('recharge', 'send', 'refund', 'adjustment', 'expired') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE store_sms MODIFY COLUMN type ENUM('recharge', 'send', 'refund', 'adjustment') NOT NULL");
    }
};
