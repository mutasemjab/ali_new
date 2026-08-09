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
        Schema::create('store_sms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');

             $table->enum('type', [
                'recharge',   // شحن
                'send',       // إرسال
                'refund',     // استرجاع
                'adjustment'  // تعديل يدوي
            ]);

            $table->integer('quantity'); // +500 أو -10

            $table->integer('balance_after'); // الرصيد بعد العملية

            $table->string('reference')->nullable(); // رقم الفاتورة أو الحملة

            $table->text('note')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_sms');
    }
};
