<?php

namespace App\Livewire\Admin\Academics;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Exam;
use App\Models\Setting;

#[Layout('layouts.app')]
class ManageExams extends Component
{
    public $exam_id = null;
    public $name = '';
    public $academic_session = '';
    public $start_date = '';
    
    public $isEditing = false;

    public function mount()
    {
        $this->academic_session = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
    }

    public function saveExam()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'academic_session' => 'required|string|max:50',
            'start_date' => 'required|date',
        ]);

        Exam::updateOrCreate(
            ['id' => $this->exam_id],
            [
                'name' => $this->name,
                'academic_session' => $this->academic_session,
                'start_date' => $this->start_date,
            ]
        );

        $message = $this->isEditing ? 'Exam updated successfully!' : 'New Exam created successfully!';
        session()->flash('success', $message);

        $this->resetForm();
    }

    public function editExam($id)
    {
        $exam = Exam::findOrFail($id);
        
        $this->exam_id = $exam->id;
        $this->name = $exam->name;
        $this->academic_session = $exam->academic_session;
        $this->start_date = $exam->start_date;
        
        $this->isEditing = true;
    }

    public function deleteExam($id)
    {
        Exam::findOrFail($id)->delete();
        session()->flash('success', 'Exam deleted successfully!');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['exam_id', 'name', 'start_date', 'isEditing']);
        $this->academic_session = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        $this->resetValidation();
    }

    public function render()
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();

        return view('livewire.admin.academics.manage-exams', [
            'exams' => $exams
        ]);
    }
}