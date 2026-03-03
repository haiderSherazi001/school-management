<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->unique(); 
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('academic_session');
            $table->string('billing_month'); 
            $table->integer('amount');
            $table->date('due_date');
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            $table->timestamp('paid_at')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_vouchers');
    }
};