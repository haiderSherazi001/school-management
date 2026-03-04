<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Portal extends Component
{
    public function render()
    {
        $user = Auth::user()->load([
            'staffProfile.designation',
            'payslips' => function($q) {
                $q->orderBy('billing_month', 'desc');
            }
        ]);

        return view('livewire.staff.portal', [
            'user' => $user,
            'profile' => $user->staffProfile,
            'payslips' => $user->payslips
        ]);
    }
}