<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

#[Layout('layouts.app')]
class Portal extends Component
{
    public function render()
    {
        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        
        $user = Auth::user()->load([
            'studentProfile', 
            'enrollments' => function($q) use ($currentSession) {
                $q->where('academic_session', $currentSession)->with('class');
            },
            'feeVouchers' => function($q) {
                $q->where('status', 'unpaid')->orderBy('due_date', 'asc');
            }
        ]);

        return view('livewire.student.portal', [
            'user' => $user,
            'profile' => $user->studentProfile,
            'currentEnrollment' => $user->enrollments->first(),
            'pendingFees' => $user->feeVouchers
        ]);
    }
}