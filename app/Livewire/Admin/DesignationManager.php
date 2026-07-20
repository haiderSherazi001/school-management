<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Designation;

#[Layout('layouts.app')]
class DesignationManager extends Component
{
    public $designation_id = null;
    public $title = '';
    public $default_salary = 0;
    public $paid_leave_days_per_month = 2;
    public $department = '';
    public $is_active = true;
    public $isEditing = false;

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255|unique:designations,title,' . $this->designation_id,
            'department' => 'nullable|string|max:255',
            'default_salary' => 'required|numeric|min:0',
            'paid_leave_days_per_month' => 'required|integer|min:0|max:31',
            'is_active' => 'boolean',
        ]);

        Designation::updateOrCreate(
            ['id' => $this->designation_id],
            [
                'title' => $this->title,
                'department' => $this->department,
                'default_salary' => $this->default_salary,
                'paid_leave_days_per_month' => $this->paid_leave_days_per_month,
                'is_active' => $this->is_active,
            ]
        );

        session()->flash('success', $this->isEditing ? 'Designation updated successfully!' : 'New designation added!');

        $this->resetForm();
    }

    public function edit($id)
    {
        $designation = Designation::findOrFail($id);
        $this->designation_id = $designation->id;
        $this->title = $designation->title;
        $this->department = $designation->department;
        $this->default_salary = $designation->default_salary;
        $this->paid_leave_days_per_month = $designation->paid_leave_days_per_month;
        $this->is_active = $designation->is_active;
        $this->isEditing = true;
    }

    public function resetForm()
    {
        $this->reset(['designation_id', 'title', 'department', 'default_salary', 'paid_leave_days_per_month', 'is_active', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.admin.designation-manager', [
            'designations' => Designation::orderBy('department')->orderBy('title')->get() 
        ]);
    }
}