<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->dropColumn('designation');
            $table->foreignId('designation_id')->nullable()->constrained('designations')->nullOnDelete();
            $table->enum('employment_status', ['active', 'on_leave', 'resigned', 'terminated'])->default('active')->after('joining_date');
        });
    }

    public function down(): void
    {
        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->string('designation')->nullable();
            $table->dropForeign(['designation_id']);
            $table->dropColumn('designation_id');
            $table->dropColumn('employment_status');
        });
    }
};