<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $classes = Classes::all();

        // Standard subjects for a typical Pakistani/South Asian school
        $standardSubjects = [
            ['name' => 'English', 'total_marks' => 100],
            ['name' => 'Urdu', 'total_marks' => 100],
            ['name' => 'Mathematics', 'total_marks' => 100],
            ['name' => 'General Science', 'total_marks' => 100],
            ['name' => 'Islamiat', 'total_marks' => 50],
            ['name' => 'Social Studies', 'total_marks' => 100],
            ['name' => 'Computer Science', 'total_marks' => 50],
            ['name' => 'Arabic', 'total_marks' => 100],
            ['name' => 'Persian', 'total_marks' => 100],
            ['name' => 'Physics', 'total_marks' => 100],
            ['name' => 'Chemistry', 'total_marks' => 100],
            ['name' => 'Biology', 'total_marks' => 100],
            ['name' => 'ترجمۃ القرآن', 'total_marks' => 100],
            ['name' => 'Civics', 'total_marks' => 100],
        ];

        foreach ($classes as $schoolClass) {
            foreach ($standardSubjects as $subject) {
                Subject::updateOrCreate(
                    [
                        'class_id' => $schoolClass->id,
                        'name' => $subject['name'],
                    ],
                    [
                        'total_marks' => $subject['total_marks'],
                    ]
                );
            }
        }
    }
}