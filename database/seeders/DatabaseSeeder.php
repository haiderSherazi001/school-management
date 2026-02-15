<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Classes;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- 1. ROLES ---
        $adminRole   = Role::firstOrCreate(['name' => 'Admin']);
        $studentRole = Role::firstOrCreate(['name' => 'Student']);
        $staffRole   = Role::firstOrCreate(['name' => 'Staff']);

        // --- 2. ADMIN USER ---
        if (!User::where('email', 'mrhyder290@school.com')->exists()) {
            User::create([
                'name' => 'Haider',
                'email' => 'mrhyder290@school.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]);
        }

        // --- 3. CLASSES ---
        
        $classes = [
            // --- JUNIOR & MIDDLE (Description is NULL) ---
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

            ['name' => '9th (Computer)', 'numeric' => 9, 'desc' => 'SSC Part-I (Computer Science Group)'],
            ['name' => '9th (Biology)',  'numeric' => 9, 'desc' => 'SSC Part-I (Biology Group)'],
            ['name' => '9th (Arts)',     'numeric' => 9, 'desc' => 'SSC Part-I (Humanities/Arts)'],

            ['name' => '10th (Computer)', 'numeric' => 10, 'desc' => 'SSC Part-II (Computer Science Group)'],
            ['name' => '10th (Biology)',  'numeric' => 10, 'desc' => 'SSC Part-II (Biology Group)'],
            ['name' => '10th (Arts)',     'numeric' => 10, 'desc' => 'SSC Part-II (Humanities/Arts)'],

            ['name' => '11th (Pre-Medical)', 'numeric' => 11, 'desc' => 'HSSC Part-I (Physics, Chemistry, Biology)'],
            ['name' => '11th (Pre-Eng)',     'numeric' => 11, 'desc' => 'HSSC Part-I (Physics, Chemistry, Math)'],
            ['name' => '12th (Pre-Medical)', 'numeric' => 12, 'desc' => 'HSSC Part-II (Physics, Chemistry, Biology)'],
            ['name' => '12th (Pre-Eng)',     'numeric' => 12, 'desc' => 'HSSC Part-II (Physics, Chemistry, Math)'],
            ['name' => '11th (ICS - Physics)', 'numeric' => 11, 'desc' => 'HSSC Part-I (Math, Computer, Physics)'],
            ['name' => '11th (ICS - Stats)',   'numeric' => 11, 'desc' => 'HSSC Part-I (Math, Computer, Statistics)'],
            ['name' => '12th (ICS - Physics)', 'numeric' => 12, 'desc' => 'HSSC Part-II (Math, Computer, Physics)'],
            ['name' => '12th (ICS - Stats)',   'numeric' => 12, 'desc' => 'HSSC Part-II (Math, Computer, Statistics)'],

            ['name' => '11th (F.A General)', 'numeric' => 11, 'desc' => 'HSSC Part-I (Arts & Humanities)'],
            ['name' => '11th (F.A IT)',      'numeric' => 11, 'desc' => 'HSSC Part-I (Fine Arts with IT)'],
            ['name' => '12th (F.A General)', 'numeric' => 12, 'desc' => 'HSSC Part-II (Arts & Humanities)'],
            ['name' => '12th (F.A IT)',      'numeric' => 12, 'desc' => 'HSSC Part-II (Fine Arts with IT)'],
            ['name' => '11th (I.Com)', 'numeric' => 11, 'desc' => 'HSSC Part-I (Commerce Group)'],
            ['name' => '12th (I.Com)', 'numeric' => 12, 'desc' => 'HSSC Part-II (Commerce Group)'],
        ];

        foreach ($classes as $class) {
            Classes::create([
                'name' => $class['name'],
                'numeric_value' => $class['numeric'],
                'description' => $class['desc'],
            ]);
        }

        // --- 4. FAKE STUDENTS ---
        $computerClass = Classes::where('name', '10th (Computer)')->first();

        if ($computerClass) {
            StudentProfile::factory(5)->create([
                'class_id' => $computerClass->id,
            ]);
        }
    }
}
