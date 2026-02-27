<?php

namespace App\Livewire\Staff;
use Livewire\Attributes\Layout;

use Livewire\Component;

#[Layout('layouts.app')]
class Portal extends Component
{
    public function render()
    {
        return view('livewire.staff.portal');
    }
}
