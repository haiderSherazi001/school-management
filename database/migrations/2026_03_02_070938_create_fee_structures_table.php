<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('academic_session'); 
            $table->integer('tuition_fee'); 
            $table->timestamps();
            $table->unique(['class_id', 'academic_session']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};