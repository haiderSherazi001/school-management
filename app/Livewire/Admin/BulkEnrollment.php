<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\User;
use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class BulkEnrollment extends Component
{
    public $target_class_id = '';
    public $filter_previous_class_id = '';
    
    public $selectedStudents = [];

    public function updatingFilterPreviousClassId()
    {
        $this->selectedStudents = [];
    }

    #[Computed]
    public function eligibleStudents()
    {
        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));

        $query = User::role('Student')
            ->whereHas('studentProfile', function ($query) {
                $query->where('status', 'active');
            })
            ->whereDoesntHave('enrollments', function ($query) use ($currentSession) {
                $query->where('academic_session', $currentSession);
            })
            ->with(['studentProfile', 'enrollments' => function($query) {
                $query->latest()->limit(1);
            }]);

        if ($this->filter_previous_class_id) {
            $query->whereHas('enrollments', function ($query) {
                $query->where('class_id', $this->filter_previous_class_id);
            });
        }

        return $query->get();
    }

    public function enrollSelected()
    {
        $this->validate([
            'target_class_id' => 'required|exists:classes,id',
            'selectedStudents' => 'required|array|min:1',
        ], [
            'target_class_id.required' => 'Please select the destination class.',
            'selectedStudents.required' => 'You must select at least one student.',
        ]);

        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));

        DB::transaction(function () use ($currentSession) {
            foreach ($this->selectedStudents as $studentId) {
                Enrollment::create([
                    'user_id' => $studentId,
                    'class_id' => $this->target_class_id,
                    'academic_session' => $currentSession,
                ]);
            }
        });

        $count = count($this->selectedStudents);
        $this->reset(['target_class_id', 'selectedStudents']);
        unset($this->eligibleStudents); 

        session()->flash('success', "Successfully promoted {$count} students!");
    }

    public function render()
    {
        return view('livewire.admin.bulk-enrollment', [
            'classes' => Classes::orderBy('numeric_value')->get(),
        ]);
    }
}