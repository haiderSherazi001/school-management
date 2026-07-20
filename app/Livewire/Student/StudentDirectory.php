<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\User;
use App\Models\Payment;
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
            ->with(['studentProfile', 'enrollments.class'])
            ->withSum(['feeVouchers as total_billed' => function($query) {
                $query->whereIn('status', ['unpaid', 'partial']);
            }], 'amount')
            ->addSelect(['total_collected' => Payment::selectRaw('COALESCE(SUM(payments.amount), 0)')
                ->join('fee_vouchers', 'fee_vouchers.id', '=', 'payments.fee_voucher_id')
                ->whereColumn('fee_vouchers.user_id', 'users.id')
                ->whereNull('payments.voided_at')
                ->whereIn('fee_vouchers.status', ['unpaid', 'partial'])])
            ->latest()
            ->paginate(10)
            ->through(function ($student) {
                $student->pending_dues = max(0, (float) $student->total_billed - (float) $student->total_collected);
                return $student;
            });

        return view('livewire.student.student-directory', [
            'students' => $students
        ]);
    }
}