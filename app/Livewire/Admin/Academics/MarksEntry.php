<?php

namespace App\Livewire\Admin\Academics;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use App\Models\ExamMark;
use App\Models\Setting;

#[Layout('layouts.app')]
class MarksEntry extends Component
{
    public $currentSession;
    public $exam_id = '';
    public $class_id = '';
    public $student_id = '';
    
    public $exams = [];
    public $classes = [];
    public $students = [];
    public $subjects = [];

    // Structure: [$subjectId] => ['obtained' => '', 'total' => '']
    public $marksData = [];

    public function mount()
    {
        $this->currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        $this->exams = Exam::orderBy('start_date', 'desc')->get();
        $this->classes = Classes::orderBy('name')->get();
    }

    public function updatedClassId()
    {
        $this->student_id = '';
        $this->marksData = [];
        if ($this->class_id) {
            $this->students = User::role('Student')
                ->whereHas('enrollments', function ($q) {
                    $q->where('class_id', $this->class_id)
                      ->where('academic_session', $this->currentSession);
                })->orderBy('name')->get();
        }
    }

    public function loadStudentRoster()
    {
        $this->validate([
            'exam_id' => 'required',
            'class_id' => 'required',
            'student_id' => 'required',
        ]);

        $this->subjects = Subject::where('class_id', $this->class_id)->orderBy('name')->get();
        
        $existingMarks = ExamMark::where('exam_id', $this->exam_id)
            ->where('student_id', $this->student_id)
            ->get()
            ->keyBy('subject_id');

        $this->marksData = [];
        foreach ($this->subjects as $subject) {
            $record = $existingMarks[$subject->id] ?? null;
            
            $this->marksData[$subject->id] = [
                'obtained' => $record ? $record->obtained_marks : '',
                'total' => $record ? $record->total_marks : $subject->total_marks,
                'is_absent' => $record ? (bool)$record->is_absent : false,
            ];
        }
    }

    public function saveStudentMarks()
    {
        $this->validate([
            'marksData.*.obtained' => 'nullable|numeric|min:0',
            'marksData.*.total' => 'required|numeric|min:1',
        ]);

        foreach ($this->marksData as $subjectId => $data) {
            if ($data['obtained'] !== '' || $data['is_absent']) {
                ExamMark::updateOrCreate(
                    [
                        'exam_id' => $this->exam_id,
                        'student_id' => $this->student_id,
                        'subject_id' => $subjectId,
                    ],
                    [
                        'obtained_marks' => $data['is_absent'] ? null : $data['obtained'],
                        'total_marks' => $data['total'],
                        'is_absent' => $data['is_absent'],
                    ]
                );
            }
        }

        session()->flash('success', 'Marks for this student have been updated.');
    }

    public function render()
    {
        return view('livewire.admin.academics.marks-entry');
    }
}