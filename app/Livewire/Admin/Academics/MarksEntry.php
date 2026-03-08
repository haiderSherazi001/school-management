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
    public $subject_id = '';
    
    public $exam_total_marks = 100;

    public $exams = [];
    public $classes = [];
    public $subjects = [];
    public $students = [];

    public $marksData = [];

    public function mount()
    {
        $this->currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        $this->exams = Exam::orderBy('start_date', 'desc')->get();
        $this->classes = Classes::orderBy('name')->get();
    }

    public function updatedClassId()
    {
        $this->subject_id = '';
        $this->students = [];
        
        if ($this->class_id) {
            $this->subjects = Subject::where('class_id', $this->class_id)->orderBy('name')->get();
        } else {
            $this->subjects = [];
        }
    }

    public function loadStudents()
    {
        $this->validate([
            'exam_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
        ]);

        // 1. Determine the Total Marks
        $subject = Subject::find($this->subject_id);
        $this->exam_total_marks = $subject->total_marks ?? 100;

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

        $existingMarks = ExamMark::where('exam_id', $this->exam_id)
            ->where('subject_id', $this->subject_id)
            ->get()
            ->keyBy('student_id');

        if ($existingMarks->count() > 0) {
            $this->exam_total_marks = $existingMarks->first()->total_marks;
        }

        $this->marksData = [];

        foreach ($this->students as $student) {
            $markRecord = $existingMarks[$student->id] ?? null;

            $this->marksData[$student->id] = [
                'obtained_marks' => $markRecord ? $markRecord->obtained_marks : '',
                'is_absent' => $markRecord ? (bool) $markRecord->is_absent : false,
                'remarks' => $markRecord ? $markRecord->remarks : '',
            ];
        }
    }

    public function saveMarks()
    {
        $this->validate([
            'exam_id' => 'required',
            'subject_id' => 'required',
            'exam_total_marks' => 'required|numeric|min:1',
            'marksData' => 'required|array',
            'marksData.*.obtained_marks' => 'nullable|numeric|min:0|lte:exam_total_marks',
            'marksData.*.remarks' => 'nullable|string|max:255',
        ], [
            'marksData.*.obtained_marks.lte' => 'Marks cannot exceed the Total Marks limit.',
        ]);

        foreach ($this->marksData as $studentId => $data) {
            
            $obtained = $data['is_absent'] ? null : ($data['obtained_marks'] !== '' ? $data['obtained_marks'] : null);

            ExamMark::updateOrCreate(
                [
                    'exam_id' => $this->exam_id,
                    'subject_id' => $this->subject_id,
                    'student_id' => $studentId,
                ],
                [
                    'total_marks' => $this->exam_total_marks,
                    'obtained_marks' => $obtained,
                    'is_absent' => $data['is_absent'],
                    'remarks' => $data['remarks'] ?? null,
                ]
            );
        }

        session()->flash('success', 'Exam marks saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.academics.marks-entry');
    }
}