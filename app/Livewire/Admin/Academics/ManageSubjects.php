<?php

namespace App\Livewire\Admin\Academics;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Classes;
use App\Models\Subject;

#[Layout('layouts.app')]
class ManageSubjects extends Component
{
    public $class_id = '';
    
    public $subject_id = null;
    public $name = '';
    public $total_marks = 100;
    public $isEditing = false;

    public function saveSubject()
    {
        $this->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'total_marks' => 'required|numeric|min:1',
        ]);

        Subject::updateOrCreate(
            ['id' => $this->subject_id],
            [
                'class_id' => $this->class_id,
                'name' => $this->name,
                'total_marks' => $this->total_marks,
            ]
        );

        $message = $this->isEditing ? 'Subject updated successfully!' : 'Subject added successfully!';
        session()->flash('success', $message);
        
        $this->resetForm();
    }

    public function editSubject($id)
    {
        $subject = Subject::findOrFail($id);
        
        $this->subject_id = $subject->id;
        $this->name = $subject->name;
        $this->total_marks = $subject->total_marks;
        $this->isEditing = true;
    }

    public function deleteSubject($id)
    {
        Subject::findOrFail($id)->delete();
        session()->flash('success', 'Subject deleted successfully!');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['subject_id', 'name', 'isEditing']);
        $this->total_marks = 100;
        $this->resetValidation();
    }

    public function updatedClassId()
    {
        $this->resetForm();
    }

    public function render()
    {
        $classes = Classes::orderBy('name')->get();
        
        $subjects = [];
        if ($this->class_id) {
            $subjects = Subject::where('class_id', $this->class_id)->orderBy('name')->get();
        }

        return view('livewire.admin.academics.manage-subjects', [
            'classes' => $classes,
            'subjects' => $subjects,
        ]);
    }
}