<?php

namespace App\Livewire\Academic;

use Livewire\Component;
use App\Models\Classes;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageClasses extends Component
{
    use WithPagination;

    public $search = '';
    public $isEditing = false;

    public $classId = null;
    public $name = '';
    public $numeric_value = '';
    public $description = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|integer|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        Classes::updateOrCreate(
            ['id' => $this->classId],
            [
                'name' => $this->name,
                'numeric_value' => $this->numeric_value,
                'description' => $this->description,
            ]
        );

        session()->flash('success', $this->isEditing ? 'Class updated successfully!' : 'Class added successfully!');
        
        $this->resetForm();
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);
        
        $this->classId = $class->id;
        $this->name = $class->name;
        $this->numeric_value = $class->numeric_value;
        $this->description = $class->description;
        
        $this->isEditing = true;
    }

    public function delete($id)
    {
        Classes::findOrFail($id)->delete();
        session()->flash('success', 'Class removed successfully!');
        
        if ($this->classId == $id) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['classId', 'name', 'numeric_value', 'description', 'isEditing']);
        $this->resetValidation();
    }

    public function render()
    {
        $classes = Classes::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy('numeric_value', 'asc')
            ->paginate(10);

        return view('livewire.academic.manage-classes', [
            'classes' => $classes
        ]);
    }
}