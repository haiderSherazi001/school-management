<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class StudentDirectory extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'active';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }
    
    public function delete($id)
    {
        $student = User::findOrFail($id);
        
        if ($student->studentProfile) {
            $student->studentProfile->delete();
        }
        
        $student->delete();
        session()->flash('success', 'Student record removed successfully!');
    }

    public function render()
    {
        $students = User::role('Student')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhereHas('studentProfile', function ($subQuery) {
                          $subQuery->where('roll_number', 'like', '%' . $this->search . '%')
                                   ->orWhere('cnic', 'like', '%' . $this->search . '%')
                                   ->orWhere('guardian_name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->whereHas('studentProfile', function ($subQuery) {
                    $subQuery->where('status', $this->statusFilter);
                });
            })
            ->with(['studentProfile', 'enrollments.academicClass']) 
            ->withSum(['feeVouchers as pending_dues' => function($query) {
                $query->where('status', 'unpaid');
            }], 'amount')
            ->latest() 
            ->paginate(10);

        return view('livewire.student.student-directory', [
            'students' => $students
        ]);
    }
}