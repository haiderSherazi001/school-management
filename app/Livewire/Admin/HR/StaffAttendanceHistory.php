<?php

namespace App\Livewire\Admin\HR;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

#[Layout('layouts.app')]
class StaffAttendanceHistory extends Component
{
    public $month;

    public function mount()
    {
        $this->month = now()->format('Y-m');
    }

    public function render()
    {
        $staffMembers = User::role('staff')
            ->whereHas('staffProfile', function ($query) {
                $query->where('employment_status', 'active');
            })
            ->with('staffProfile.designation')
            ->orderBy('name')
            ->get();

        $startDate = Carbon::createFromFormat('Y-m', $this->month)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $attendanceMatrix = Attendance::whereIn('user_id', $staffMembers->pluck('id'))
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get()
            ->groupBy('user_id')
            ->map(fn ($records) => $records->keyBy(fn ($record) => $record->date->day));

        return view('livewire.admin.hr.staff-attendance-history', [
            'staffMembers' => $staffMembers,
            'attendanceMatrix' => $attendanceMatrix,
            'daysInMonth' => $startDate->daysInMonth,
            'monthLabel' => $startDate->format('F Y'),
        ]);
    }
}
