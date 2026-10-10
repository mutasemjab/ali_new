<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_plan_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_plan_id')->nullable()->constrained()->nullOnDelete();
            // Snapshot of the plan's name at submission time, so the lead stays
            // readable even if the plan is later renamed or deleted.
            $table->string('plan_name')->nullable();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_plan_inquiries');
    }
};
