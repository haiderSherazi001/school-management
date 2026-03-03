<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\StaffProfile;
use App\Models\Setting;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        $schoolName = Setting::get('school_name', 'Your School');

        $totalStudents = User::role('Student')->whereHas('studentProfile', function ($query) {
            $query->where('status', 'active');
        })->count();
        
        $enrolledStudents = User::role('Student')->whereHas('studentProfile', function ($query) {
            $query->where('status', 'active');
        })->whereHas('enrollments', function ($query) use ($currentSession) {
            $query->where('academic_session', $currentSession);
        })->count();
        
        $unassignedStudents = $totalStudents - $enrolledStudents;

        $totalAlumni = StudentProfile::where('status', 'graduated')->count();
        $totalLeft = StudentProfile::where('status', 'struck_off')->count();

        $activeStaff = StaffProfile::where('employment_status', 'active')->count(); 
        $totalClasses = Classes::count();

        return view('livewire.admin.dashboard', [
            'currentSession' => $currentSession,
            'schoolName' => $schoolName,
            'totalStudents' => $totalStudents,
            'enrolledStudents' => $enrolledStudents,
            'unassignedStudents' => $unassignedStudents,
            'totalAlumni' => $totalAlumni,
            'totalLeft' => $totalLeft,
            'activeStaff' => $activeStaff,
            'totalClasses' => $totalClasses,
        ]);
    }
}