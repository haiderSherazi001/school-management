<?php

namespace App\Livewire\Admin\HR;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

#[Layout('layouts.app')]
class StaffAttendance extends Component
{
    public $attendanceDate;
    
    public $attendanceData = [];
    public $remarksData = []; 

    public function mount()
    {
        $this->attendanceDate = date('Y-m-d');
        $this->loadStaffList();
    }

    public function updatedAttendanceDate()
    {
        $this->loadStaffList();
    }

    public function loadStaffList()
    {
        $staffMembers = User::role('staff')
            ->whereHas('staffProfile', function ($query) {
                $query->where('employment_status', 'active'); 
            })
            ->orderBy('name')
            ->get();
                
        $existingRecords = Attendance::where('date', $this->attendanceDate)
                                     ->get()
                                     ->keyBy('user_id');

        $this->attendanceData = [];
        $this->remarksData = []; 

        foreach ($staffMembers as $staff) {
            $record = $existingRecords[$staff->id] ?? null;

            $this->attendanceData[$staff->id] = $record ? $record->status : 'present';
            $this->remarksData[$staff->id] = $record ? $record->remarks : ''; 
        }
    }

    public function saveAttendance()
    {
        $this->validate([
            'attendanceDate' => 'required|date|before_or_equal:today',
            'attendanceData' => 'required|array',
            'remarksData' => 'nullable|array',
            'remarksData.*' => 'nullable|string|max:255', 
        ]);

        foreach ($this->attendanceData as $userId => $status) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $userId, 
                    'date' => $this->attendanceDate
                ],
                [
                    'status' => $status,
                    'remarks' => $this->remarksData[$userId] ?? null, 
                ]
            );
        }

        session()->flash('success', 'Attendance for ' . Carbon::parse($this->attendanceDate)->format('d M, Y') . ' saved successfully!');
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

        return view('livewire.admin.hr.staff-attendance', [
            'staffMembers' => $staffMembers
        ]);
    }
}