<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

#[Layout('layouts.app')]
class ShowStaff extends Component
{
    public User $staff;

    public function mount(User $staff)
    {
        $this->staff = $staff->load('staffProfile');
    }

    public function render()
    {
        return view('livewire.staff.show-staff');
    }
}