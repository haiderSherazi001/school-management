<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('academic_session');
            $table->timestamps();

            $table->unique(['user_id', 'academic_session']);
        });

        $currentSession = Setting::get('current_session', '2025-2026');
        
        $oldProfiles = DB::table('student_profiles')->whereNotNull('class_id')->get();
        
        foreach ($oldProfiles as $profile) {
            DB::table('enrollments')->insert([
                'user_id' => $profile->user_id,
                'class_id' => $profile->class_id,
                'academic_session' => $currentSession,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropForeign(['class_id']); 
            $table->dropColumn('class_id');
        });
    }

    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->foreignId('class_id')->nullable()->constrained('classes')->cascadeOnDelete();
        });

        Schema::dropIfExists('enrollments');
    }
};