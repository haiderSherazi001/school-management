<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Classes;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole   = Role::firstOrCreate(['name' => 'Admin']);
        $studentRole = Role::firstOrCreate(['name' => 'Student']);
        $staffRole   = Role::firstOrCreate(['name' => 'Staff']);

        // --- 2. ADMIN USER ---
        $adminUser = User::firstOrCreate( 
            ['username' => 'admin'],
            [
                'name' => 'Haider',
                'email' => 'mrhyder29@school.com',
                'password' => Hash::make('password'),
            ]
        );

        // 3. ASSIGN THE ROLE
        $adminUser->assignRole($adminRole);

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

            ['name' => '9th', 'numeric' => 9, 'desc' => 'Computer Science Group'],
            ['name' => '9th',  'numeric' => 9, 'desc' => 'Biology Group'],
            ['name' => '9th',     'numeric' => 9, 'desc' => 'Humanities/Arts'],

            ['name' => '10th', 'numeric' => 10, 'desc' => 'Computer Science Group'],
            ['name' => '10th',  'numeric' => 10, 'desc' => 'Biology Group'],
            ['name' => '10th',     'numeric' => 10, 'desc' => 'Humanities/Arts'],

            ['name' => '11th', 'numeric' => 11, 'desc' =>  'Pre-Med'],
            ['name' => '11th',     'numeric' => 11, 'desc' => 'Pre-Eng'],
            ['name' => '12th', 'numeric' => 12, 'desc' => 'Pre-Med'],
            ['name' => '12th',     'numeric' => 12, 'desc' => 'Pre-Eng'],
            ['name' => '11th', 'numeric' => 11, 'desc' => 'ICS - Physics'],
            ['name' => '11th',   'numeric' => 11, 'desc' => 'ICS - Stats'],
            ['name' => '12th', 'numeric' => 12, 'desc' => 'ICS - Physics'],
            ['name' => '12th',   'numeric' => 12, 'desc' => 'ICS - Stats'],

            ['name' => '11th', 'numeric' => 11, 'desc' => 'F.A-General'],
            ['name' => '11th',      'numeric' => 11, 'desc' => 'F.A-IT'],
            ['name' => '12th', 'numeric' => 12, 'desc' => 'F.A-General'],
            ['name' => '12th',      'numeric' => 12, 'desc' => 'F.A-IT'],
            ['name' => '11th', 'numeric' => 11, 'desc' => 'I.Com'],
            ['name' => '12th', 'numeric' => 12, 'desc' => 'I.Com'],
        ];

        foreach ($classes as $class) {
            Classes::firstOrCreate(
                ['name' => $class['name'],
                'description' => $class['desc']
                ],

                [
                    'numeric_value' => $class['numeric'],
                ]
            );
        }

        // --- 5. FAKE STUDENTS ---
        
        // $computerClass = Classes::where('name', '10th')
        //                 ->where('description', 'Computer Science Group')
        //                 ->first();
        // if ($computerClass) {
        //     StudentProfile::factory(5)->create([
        //         'class_id' => $computerClass->id,
        //     ]);
        // }
        
    }
}