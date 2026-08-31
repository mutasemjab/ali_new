<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weekly_ads', function (Blueprint $table) {
            $table->string('token', 40)->nullable()->after('id');
        });

        DB::table('weekly_ads')->whereNull('token')->orderBy('id')->get(['id'])->each(function ($row) {
            DB::table('weekly_ads')->where('id', $row->id)->update(['token' => Str::random(32)]);
        });

        Schema::table('weekly_ads', function (Blueprint $table) {
            $table->string('token', 40)->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weekly_ads', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
};
