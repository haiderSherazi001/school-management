<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->unsignedTinyInteger('paid_leave_days_per_month')->nullable()->after('employment_status');
            $table->text('leave_note')->nullable()->after('paid_leave_days_per_month');
        });
    }

    public function down(): void
    {
        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->dropColumn(['paid_leave_days_per_month', 'leave_note']);
        });
    }
};
