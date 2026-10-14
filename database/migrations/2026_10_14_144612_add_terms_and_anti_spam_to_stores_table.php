<?php

use App\Models\AppSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('stores', function (Blueprint $table) {
            // stores.privacy_policy already exists (unused leftover column) — reused here.
            $table->text('terms_of_service')->nullable()->after('privacy_policy');
            $table->text('anti_spam_policy')->nullable()->after('terms_of_service');
        });

        // Legal docs move from one shared admin-wide copy to one per store. Seed every
        // store with what was already being shown under the old shared setup, so nothing
        // goes blank — each store can then customize its own from here on.
        $shared = AppSetting::current();

        DB::table('stores')->update([
            'privacy_policy' => $shared->privacy_policy,
            'terms_of_service' => $shared->terms_of_service,
            'anti_spam_policy' => $shared->anti_spam_policy,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['terms_of_service', 'anti_spam_policy']);
        });
    }
};
