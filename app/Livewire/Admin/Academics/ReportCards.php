<?php

namespace App\Livewire\Admin\Academics;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\User;
use App\Models\Setting;

#[Layout('layouts.app')]
class ReportCards extends Component
{
    public $currentSession;
    public $exam_id = '';
    public $class_id = '';
    
    public $exams = [];
    public $classes = [];
    public $students = [];

    public function mount()
    {
        $this->currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        $this->exams = Exam::orderBy('start_date', 'desc')->get();
        $this->classes = Classes::orderBy('name')->get();
    }

    public function loadStudents()
    {
        $this->validate([
            'exam_id' => 'required',
            'class_id' => 'required',
        ]);

        $this->students = User::role('Student')
            ->whereHas('studentProfile', function ($query) {
                $query->where('status', 'active');
            })
            ->whereHas('enrollments', function ($query) {
                $query->where('class_id', $this->class_id)
                      ->where('academic_session', $this->currentSession);
            })
            ->with('studentProfile')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.academics.report-cards');
    }
}