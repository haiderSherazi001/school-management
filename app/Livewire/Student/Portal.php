<?php

namespace App\Livewire\Student;

use Livewire\Attributes\Layout;

use Livewire\Component;

#[Layout('layouts.app')]
class Portal extends Component
{
    public function render()
    {
        return view('livewire.student.portal');
    }
}
