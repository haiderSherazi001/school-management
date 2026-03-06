<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\User;
use App\Models\FeeVoucher;
use App\Models\FeeVoucherItem;
use App\Models\Setting;
use App\Models\Enrollment;


#[Layout('layouts.app')]
class FeeCollection extends Component
{
    public $search = '';
    public $selectedStudentId = null;

    public $activeVoucherId = null;
    public $newItemTitle = '';
    public $newItemAmount = '';

    public $showInstantBillForm = false;
    public $instantBillTitle = '';
    public $instantBillAmount = '';

    public function selectStudent($id)
    {
        $this->selectedStudentId = $id;
        $this->search = '';
        $this->activeVoucherId = null;
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

    public function openAddItemForm($voucherId)
    {
        $this->activeVoucherId = $voucherId;
        $this->newItemTitle = '';
        $this->newItemAmount = '';
        $this->resetValidation();
    }

    public function closeAddItemForm()
    {
        $this->activeVoucherId = null;
    }

    public function saveCustomItem()
    {
        $this->validate([
            'newItemTitle' => 'required|string|max:255',
            'newItemAmount' => 'required|numeric|min:1',
        ]);

        $voucher = FeeVoucher::findOrFail($this->activeVoucherId);

        $voucher->items()->create([
            'title' => $this->newItemTitle,
            'amount' => $this->newItemAmount,
        ]);

        $voucher->increment('amount', $this->newItemAmount);

        session()->flash('success', "Added Rs. {$this->newItemAmount} ({$this->newItemTitle}) to the voucher.");

        $this->closeAddItemForm();
    }

    public function toggleInstantBillForm()
    {
        $this->showInstantBillForm = !$this->showInstantBillForm;
        $this->resetValidation();
    }

    public function createInstantBill()
    {
        $this->validate([
            'instantBillTitle' => 'required|string|max:255',
            'instantBillAmount' => 'required|numeric|min:1',
        ]);

        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        
        $enrollment = Enrollment::where('user_id', $this->selectedStudentId)
            ->where('academic_session', $currentSession)
            ->first();

        if (!$enrollment) {
            session()->flash('error', 'Cannot generate bill: Student is not actively enrolled in the current session.');
            $this->showInstantBillForm = false;
            return;
        }

        $currentMonth = date('F Y'); 
        $voucherNumber = 'INST-' . date('Ym') . '-' . str_pad($this->selectedStudentId, 4, '0', STR_PAD_LEFT) . '-' . rand(100, 999);

        $voucher = FeeVoucher::create([
            'voucher_number' => $voucherNumber,
            'user_id' => $this->selectedStudentId,
            'class_id' => $enrollment->class_id,
            'academic_session' => $currentSession,
            'billing_month' => $currentMonth,
            'amount' => $this->instantBillAmount,
            'due_date' => date('Y-m-d'),
            'status' => 'unpaid',
        ]);

        $voucher->items()->create([
            'title' => $this->instantBillTitle,
            'amount' => $this->instantBillAmount,
        ]);

        session()->flash('success', "Instant Bill for '{$this->instantBillTitle}' generated successfully!");

        $this->showInstantBillForm = false;
        $this->instantBillTitle = '';
        $this->instantBillAmount = '';
    }

    public function removeCustomItem($itemId, $voucherId)
    {
        $voucher = FeeVoucher::findOrFail($voucherId);

        if ($voucher->status === 'paid') {
            session()->flash('error', 'You cannot modify a voucher that has already been paid.');
            return;
        }

        $item = FeeVoucherItem::where('fee_voucher_id', $voucherId)->findOrFail($itemId);
        
        $amountToDeduct = $item->amount;
        $title = $item->title;

        $item->delete();

        $voucher->decrement('amount', $amountToDeduct);

        session()->flash('success', "Removed {$title} (Rs. {$amountToDeduct}) from the voucher.");
    }

    #[Computed]
    public function searchResults()
    {
        if (strlen($this->search) < 2) {
            return [];
        }

        return User::role('Student')
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhereHas('studentProfile', function($query) {
                      $query->where('roll_number', 'like', '%' . $this->search . '%');
                  });
            })
            ->with('studentProfile')
            ->limit(5)
            ->get();
    }

    #[Computed]
    public function defaulters()
    {
        return User::role('Student')
            ->whereHas('feeVouchers', function($q) {
                $q->where('status', 'unpaid'); 
            })
            ->withSum(['feeVouchers as total_due' => function($q) {
                $q->where('status', 'unpaid');
            }], 'amount') 
            ->with('studentProfile')
            ->orderByDesc('total_due') 
            ->limit(15) 
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
        }, 'feeVouchers.class', 'feeVouchers.items'])
        ->findOrFail($this->selectedStudentId);
    }

    public function render()
    {
        return view('livewire.admin.fee-collection');
    }
}