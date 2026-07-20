<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Classes;
use App\Models\StaffProfile;
use App\Models\Setting;
use App\Models\FeeVoucher;
use App\Models\Payment;
use App\Models\Designation;
use Illuminate\Support\Carbon;

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
        
        $activeStaff = StaffProfile::where('employment_status', 'active')->count(); 
        $staffOnLeave = StaffProfile::where('employment_status', 'on_leave')->count();

        $collectedThisMonth = Payment::whereNull('voided_at')
            ->whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->sum('amount');

        $activeStudentBilled = FeeVoucher::whereIn('status', ['unpaid', 'partial'])
            ->whereHas('student.studentProfile', function($query) {
                $query->where('status', 'active');
            })
            ->sum('amount');

        $activeStudentCollected = Payment::whereNull('voided_at')
            ->whereHas('voucher', function($query) {
                $query->whereIn('status', ['unpaid', 'partial'])
                    ->whereHas('student.studentProfile', function($q) {
                        $q->where('status', 'active');
                    });
            })
            ->sum('amount');

        $pendingDues = max(0, $activeStudentBilled - $activeStudentCollected);

        $overdueInvoices = FeeVoucher::whereIn('status', ['unpaid', 'partial'])
            ->where('due_date', '<', Carbon::today())
            ->whereHas('student.studentProfile', function($query) {
                $query->where('status', 'active');
            })
            ->count();

        // --- 3. DATA BREAKDOWNS ---
        $classBreakdown = Classes::withCount(['enrollments' => function ($query) use ($currentSession) {
            $query->where('academic_session', $currentSession)
                  ->whereHas('student.studentProfile', function($q) {
                      $q->where('status', 'active');
                  });
        }])->orderBy('name')->get();

        $staffBreakdown = Designation::withCount(['staffProfiles' => function ($query) {
            $query->where('employment_status', 'active');
        }])->orderBy('department')->orderBy('title')->get();

        return view('livewire.admin.dashboard', [
            'currentSession' => $currentSession,
            'schoolName' => $schoolName,
            'totalStudents' => $totalStudents,
            'enrolledStudents' => $enrolledStudents,
            'unassignedStudents' => $unassignedStudents,
            'activeStaff' => $activeStaff,
            'staffOnLeave' => $staffOnLeave,
            'collectedThisMonth' => $collectedThisMonth,
            'pendingDues' => $pendingDues,
            'overdueInvoices' => $overdueInvoices,
            'classBreakdown' => $classBreakdown,
            'staffBreakdown' => $staffBreakdown,
        ]);
    }
}