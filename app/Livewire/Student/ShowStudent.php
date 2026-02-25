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
        $this->student = $student->load('studentProfile.class');
    }

    public function render()
    {
        return view('livewire.student.show-student');
    }
}