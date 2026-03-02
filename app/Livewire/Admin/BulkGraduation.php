<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\User;
use App\Models\Classes;
use App\Models\StudentProfile;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class BulkGraduation extends Component
{
    public $filter_class_id = '';
    
    public $target_status = 'graduated'; 
    
    public $selectedStudents = [];

    public function updatingFilterClassId()
    {
        $this->selectedStudents = [];
    }

    #[Computed]
    public function eligibleStudents()
    {
        if (!$this->filter_class_id) {
            return collect(); 
        }

        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));

        return User::role('Student')
            ->whereHas('studentProfile', function ($query) {
                $query->where('status', 'active');
            })
            ->whereHas('enrollments', function ($query) use ($currentSession) {
                $query->where('academic_session', $currentSession)
                      ->where('class_id', $this->filter_class_id);
            })
            ->with('studentProfile')
            ->get();
    }

    public function updateStatus()
    {
        $this->validate([
            'target_status' => 'required|in:graduated,struck_off',
            'selectedStudents' => 'required|array|min:1',
        ], [
            'selectedStudents.required' => 'Please select at least one student to update.',
        ]);

        DB::transaction(function () {
            StudentProfile::whereIn('user_id', $this->selectedStudents)
                ->update(['status' => $this->target_status]);
        });

        $count = count($this->selectedStudents);
        
        $this->reset(['selectedStudents', 'filter_class_id', 'target_status']);
        $this->target_status = 'graduated'; 
        
        unset($this->eligibleStudents); 

        session()->flash('success', "Successfully marked {$count} students as " . str_replace('_', ' ', $this->target_status) . "!");
    }

    public function render()
    {
        return view('livewire.admin.bulk-graduation', [
            'classes' => Classes::orderBy('numeric_value')->get(),
        ]);
    }
}