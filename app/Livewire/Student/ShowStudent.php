<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

#[Layout('layouts.app')]
class ShowStudent extends Component
{
    public User $student;

    public function mount(User $student)
    {
        $this->student = $student->load([
            'studentProfile',
            'enrollments.class',
            'feeVouchers' => function($query) {
                $query->latest('due_date')->limit(5)->with('payments');
            }
        ]);

        $this->student->pending_dues = \App\Models\FeeVoucher::outstandingBalanceForUser($student->id);
    }

    public function render()
    {
        return view('livewire.student.show-student');
    }
}