<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Classes;
use App\Models\Setting;
use App\Models\Designation;
use App\Models\StaffProfile;
use App\Models\StudentProfile;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. ROLES ---
        $adminRole   = Role::firstOrCreate(['name' => 'Admin']);
        $studentRole = Role::firstOrCreate(['name' => 'Student']);
        $staffRole   = Role::firstOrCreate(['name' => 'Staff']);

        // --- 2. ADMIN USER ---
        $adminUser = User::firstOrCreate( 
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@eduflow.demo',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole($adminRole);

        // --- 3. GLOBAL SETTINGS ---
        $settings = [
            ['key' => 'school_name', 'value' => 'EduFlow International Academy', 'group' => 'general'],
            ['key' => 'school_phone', 'value' => '+92 343 1830998', 'group' => 'general'],
            ['key' => 'school_email', 'value' => 'info@eduflow.demo', 'group' => 'general'],
            ['key' => 'school_address', 'value' => '123 Tech Avenue, Faisalabad, PK', 'group' => 'general'],
            ['key' => 'current_session', 'value' => '2026-2027', 'group' => 'academic'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }

        // --- 4. CLASSES ---
        $classes = [
            ['name' => 'Playgroup', 'numeric' => 0, 'desc' => null],
            ['name' => 'Nursery',   'numeric' => 0, 'desc' => null],
            ['name' => 'Prep',      'numeric' => 0, 'desc' => null],
            ['name' => 'Class 1',   'numeric' => 1, 'desc' => null],
            ['name' => 'Class 2',   'numeric' => 2, 'desc' => null],
            ['name' => 'Class 3',   'numeric' => 3, 'desc' => null],
            ['name' => 'Class 4',   'numeric' => 4, 'desc' => null],
            ['name' => 'Class 5',   'numeric' => 5, 'desc' => null],
            ['name' => 'Class 6',   'numeric' => 6, 'desc' => null],
            ['name' => 'Class 7',   'numeric' => 7, 'desc' => null],
            ['name' => 'Class 8',   'numeric' => 8, 'desc' => null],
            ['name' => '9th',       'numeric' => 9, 'desc' => 'Computer Science Group'],
            ['name' => '10th',      'numeric' => 10, 'desc' => 'Computer Science Group'],
        ];

        foreach ($classes as $class) {
            Classes::firstOrCreate(
                ['name' => $class['name'], 'description' => $class['desc']],
                ['numeric_value' => $class['numeric']]
            );
        }

        // --- 5. SUBJECTS ---
        $this->call(SubjectSeeder::class);

        // --- 6. DEMO DESIGNATIONS & STAFF ---
        $seniorTeacher = Designation::firstOrCreate(['title' => 'Senior Teacher'], ['default_salary' => 65000]);
        $juniorTeacher = Designation::firstOrCreate(['title' => 'Junior Teacher'], ['default_salary' => 45000]);
        $accountant = Designation::firstOrCreate(['title' => 'Accountant'], ['default_salary' => 55000]);

        $designations = [$seniorTeacher, $juniorTeacher, $accountant];

        for ($i = 1; $i <= 10; $i++) {
            $staffUsername = 'STF-' . date('Y') . '-' . str_pad($i, 5, '0', STR_PAD_LEFT);
            $staffCnic = fake()->unique()->numerify('#############');

            $staffUser = User::create([
                'name' => fake()->name(),
                'username' => $staffUsername,
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('cnic-' . $staffCnic),
            ]);
            $staffUser->assignRole($staffRole);
            
            StaffProfile::create([
                'user_id' => $staffUser->id,
                'cnic' => $staffCnic,
                'designation_id' => $designations[array_rand($designations)]->id,
                'qualification' => fake()->randomElement(['BSCS', 'MSc', 'PhD', 'B.Ed', 'M.Ed']),
                'phone' => fake()->numerify('03#########'),
                'personal_email' => fake()->unique()->safeEmail(),
                'address' => fake()->address(),
                'gender' => fake()->randomElement(['male', 'female']),
                'joining_date' => now()->subMonths(rand(1, 36))->format('Y-m-d'),
                'salary' => fake()->randomElement([45000, 50000, 65000]),
                'employment_status' => 'active',
            ]);
        }

        // --- 7. DEMO STUDENTS ---
        $allClasses = Classes::all();
        
        if ($allClasses->count() > 0) {
            for ($i = 1; $i <= 50; $i++) {
                $studentUsername = 'STD-' . date('Y') . '-' . str_pad($i, 5, '0', STR_PAD_LEFT);
                $dob = now()->subYears(rand(8, 16))->format('Y-m-d');
                $cleanDob = \Carbon\Carbon::parse($dob)->format('Ymd');

                $studentUser = User::create([
                    'name' => fake()->name(),
                    'username' => $studentUsername,
                    'email' => fake()->unique()->safeEmail(),
                    'password' => Hash::make('dob-' . $cleanDob),
                ]);
                $studentUser->assignRole($studentRole);
                
                $profile = StudentProfile::create([
                    'user_id' => $studentUser->id,
                    'roll_number' => $studentUsername,
                    'admission_date' => now()->subYears(rand(1, 3))->format('Y-m-d'),
                    'cnic' => fake()->unique()->numerify('#############'),
                    'date_of_birth' => $dob,
                    'gender' => fake()->randomElement(['male', 'female']),
                    'blood_group' => fake()->randomElement(['A+', 'B+', 'O+', 'AB+']),
                    'personal_phone' => fake()->numerify('03#########'),
                    'personal_email' => fake()->unique()->safeEmail(),
                    'guardian_name' => fake()->name('male'),
                    'guardian_phone' => fake()->numerify('03#########'),
                    'address' => fake()->address(),
                    'status' => 'active',
                ]);

                Enrollment::create([
                    'user_id' => $studentUser->id,
                    'class_id' => $allClasses->random()->id,
                    'academic_session' => '2026-2027',
                ]);
            }
        }

        // --- 8. DEMO FEE STRUCTURE ---
        $baseFee = 3500;
        foreach ($allClasses as $class) {
            \App\Models\FeeStructure::firstOrCreate(
                [
                    'class_id' => $class->id,
                    'academic_session' => '2026-2027'
                ],
                [
                    'tuition_fee' => $baseFee
                ]
            );
            $baseFee += 500;
        }
    }
}