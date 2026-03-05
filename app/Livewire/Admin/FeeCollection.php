<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\User;
use App\Models\FeeVoucher;

#[Layout('layouts.app')]
class FeeCollection extends Component
{
    public $search = '';
    public $selectedStudentId = null;

    public function selectStudent($id)
    {
        $this->selectedStudentId = $id;
        $this->search = '';
    }

    public function markAsPaid($voucherId)
    {
        $voucher = FeeVoucher::findOrFail($voucherId);
        
        $voucher->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        session()->flash('success', "Payment of Rs. {$voucher->amount} collected for {$voucher->billing_month}!");
    }

    public function revertPayment($voucherId)
    {
        $voucher = FeeVoucher::findOrFail($voucherId);
        
        $voucher->update([
            'status' => 'unpaid',
            'paid_at' => null,
        ]);

        session()->flash('success', "Payment reverted to unpaid.");
    }

    #[Computed]
    public function searchResults()
    {
        if (strlen($this->search) < 2) {
            return [];
        }

        return User::role('Student')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('studentProfile', function($query) {
                $query->where('roll_number', 'like', '%' . $this->search . '%');
            })
            ->with('studentProfile')
            ->limit(5)
            ->get();
    }

    #[Computed]
    public function studentLedger()
    {
        if (!$this->selectedStudentId) {
            return null;
        }

        return User::with(['studentProfile', 'feeVouchers' => function($query) {
            $query->orderByRaw("FIELD(status, 'unpaid', 'paid')")->orderBy('due_date', 'desc');
        }, 'feeVouchers.class'])
        ->findOrFail($this->selectedStudentId);
    }

    public function render()
    {
        return view('livewire.admin.fee-collection');
    }
}