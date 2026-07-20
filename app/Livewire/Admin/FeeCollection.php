<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\User;
use App\Models\FeeVoucher;
use App\Models\FeeVoucherItem;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

    public $bulkClassId = '';
    public $bulkBillingMonth = '';
    public $bulkPaymentMethod = 'cash';
    public $showBulkCollectionModal = false;

    public $activePaymentVoucherId = null;
    public $paymentAmount = '';
    public $paymentMethod = 'cash';
    public $paymentReference = '';
    public $paymentNote = '';

    public function mount()
    {
        $this->bulkBillingMonth = date('F Y');
    }

    public function openBulkModal()
    {
        $this->showBulkCollectionModal = true;
        $this->bulkClassId = '';
        $this->bulkBillingMonth = date('F Y');
        $this->bulkPaymentMethod = 'cash';
        $this->resetValidation();
        $this->dispatch('scroll-to-bulk-modal');
    }

    public function closeBulkModal()
    {
        $this->showBulkCollectionModal = false;
        $this->resetValidation();
    }

    public function selectStudent($id)
    {
        $this->selectedStudentId = $id;
        $this->search = '';
        $this->activeVoucherId = null;
        $this->activePaymentVoucherId = null;
    }

    public function openPaymentForm($voucherId)
    {
        $voucher = FeeVoucher::findOrFail($voucherId);

        $this->activePaymentVoucherId = $voucherId;
        $this->paymentAmount = number_format($voucher->balance_due, 2, '.', '');
        $this->paymentMethod = 'cash';
        $this->paymentReference = '';
        $this->paymentNote = '';
        $this->resetValidation();
    }

    public function closePaymentForm()
    {
        $this->activePaymentVoucherId = null;
        $this->paymentAmount = '';
        $this->paymentReference = '';
        $this->paymentNote = '';
    }

    public function recordPayment()
    {
        $this->validate([
            'paymentAmount' => ['required', 'numeric', 'min:0.01'],
            'paymentMethod' => ['required', 'in:cash,bank,other'],
            'paymentReference' => ['nullable', 'string', 'max:255'],
            'paymentNote' => ['nullable', 'string', 'max:500'],
        ]);

        $recordedAmount = $this->paymentAmount;

        DB::transaction(function () {
            $voucher = FeeVoucher::whereKey($this->activePaymentVoucherId)->lockForUpdate()->firstOrFail();

            if (in_array($voucher->status, ['paid', 'cancelled'])) {
                throw ValidationException::withMessages([
                    'paymentAmount' => 'This voucher cannot accept further payments.',
                ]);
            }

            $balance = $voucher->balance_due;

            if ($this->paymentAmount > $balance) {
                throw ValidationException::withMessages([
                    'paymentAmount' => 'Amount exceeds remaining balance of Rs. ' . number_format($balance, 2),
                ]);
            }

            $voucher->payments()->create([
                'amount' => $this->paymentAmount,
                'method' => $this->paymentMethod,
                'reference_number' => $this->paymentReference ?: null,
                'note' => $this->paymentNote ?: null,
                'collected_by' => auth()->id(),
                'paid_at' => now(),
            ]);

            $voucher->recalculateStatus();
        });

        session()->flash('success', 'Payment of Rs. ' . number_format($recordedAmount, 2) . ' recorded.');

        $this->closePaymentForm();
    }

    public function revertPayment($voucherId)
    {
        $voucher = FeeVoucher::findOrFail($voucherId);

        $payment = $voucher->payments()
            ->whereNull('voided_at')
            ->orderByDesc('paid_at')
            ->orderByDesc('id')
            ->first();

        if (!$payment) {
            session()->flash('error', 'No active payment to undo for this voucher.');
            return;
        }

        $payment->update([
            'voided_at' => now(),
            'voided_by' => auth()->id(),
        ]);

        $voucher->recalculateStatus();

        session()->flash('success', 'Payment of Rs. ' . number_format($payment->amount, 2) . ' has been voided.');
    }

    public function markBulkPaid()
    {
        $this->validate([
            'bulkClassId' => 'required',
            'bulkBillingMonth' => 'required|string',
            'bulkPaymentMethod' => 'required|in:cash,bank,other',
        ]);

        // Trim to prevent invisible space issues
        $cleanMonth = trim($this->bulkBillingMonth);

        $vouchers = FeeVoucher::where('class_id', $this->bulkClassId)
            ->where('billing_month', $cleanMonth)
            ->whereIn('status', ['unpaid', 'partial'])
            ->get();

        if ($vouchers->isEmpty()) {
            session()->flash('error', "No pending vouchers found for the selected class in {$cleanMonth}.");
            return;
        }

        $count = 0;
        $totalAmount = 0;

        DB::transaction(function () use ($vouchers, &$count, &$totalAmount) {
            foreach ($vouchers as $listedVoucher) {
                $voucher = FeeVoucher::whereKey($listedVoucher->id)->lockForUpdate()->first();
                $balance = $voucher->balance_due;

                if ($balance <= 0) {
                    continue;
                }

                $voucher->payments()->create([
                    'amount' => $balance,
                    'method' => $this->bulkPaymentMethod,
                    'collected_by' => auth()->id(),
                    'paid_at' => now(),
                ]);

                $voucher->recalculateStatus();

                $count++;
                $totalAmount += $balance;
            }
        });

        session()->flash('success', "Successfully collected payments for {$count} vouchers totaling Rs. " . number_format($totalAmount, 2) . "!");

        $this->closeBulkModal();
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

        if (in_array($voucher->status, ['paid', 'cancelled'])) {
            session()->flash('error', 'You cannot modify a voucher that has already been paid.');
            $this->closeAddItemForm();
            return;
        }

        $voucher->items()->create([
            'title' => $this->newItemTitle,
            'amount' => $this->newItemAmount,
        ]);

        $voucher->increment('amount', $this->newItemAmount);
        $voucher->recalculateStatus();

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

        if (in_array($voucher->status, ['paid', 'cancelled'])) {
            session()->flash('error', 'You cannot modify a voucher that has already been paid.');
            return;
        }

        $item = FeeVoucherItem::where('fee_voucher_id', $voucherId)->findOrFail($itemId);

        $amountToDeduct = $item->amount;
        $title = $item->title;

        $item->delete();

        $voucher->decrement('amount', $amountToDeduct);
        $voucher->recalculateStatus();

        session()->flash('success', "Removed {$title} (Rs. {$amountToDeduct}) from the voucher.");
    }

    #[Computed]
    public function pendingVoucherDetails()
    {
        if (empty($this->bulkClassId) || empty($this->bulkBillingMonth)) {
            return collect();
        }

        $cleanMonth = trim($this->bulkBillingMonth);

        $vouchers = FeeVoucher::where('class_id', $this->bulkClassId)
            ->where('billing_month', $cleanMonth)
            ->whereIn('status', ['unpaid', 'partial'])
            ->with('payments')
            ->get();

        $users = User::whereIn('id', $vouchers->pluck('user_id'))->pluck('name', 'id');

        return $vouchers->map(function($voucher) use ($users) {
            $voucher->student_name = $users[$voucher->user_id] ?? 'Unknown Student';
            return $voucher;
        });
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
        $collectedSubquery = Payment::selectRaw('COALESCE(SUM(payments.amount), 0)')
            ->join('fee_vouchers', 'fee_vouchers.id', '=', 'payments.fee_voucher_id')
            ->whereColumn('fee_vouchers.user_id', 'users.id')
            ->whereNull('payments.voided_at')
            ->whereIn('fee_vouchers.status', ['unpaid', 'partial']);

        return User::role('Student')
            ->whereHas('feeVouchers', function($q) {
                $q->whereIn('status', ['unpaid', 'partial']);
            })
            ->withSum(['feeVouchers as total_billed' => function($q) {
                $q->whereIn('status', ['unpaid', 'partial']);
            }], 'amount')
            ->addSelect(['total_collected' => $collectedSubquery])
            ->with('studentProfile')
            ->get()
            ->each(function ($student) {
                $student->total_due = (float) $student->total_billed - (float) $student->total_collected;
            })
            ->sortByDesc('total_due')
            ->take(15)
            ->values();
    }

    #[Computed]
    public function studentLedger()
    {
        if (!$this->selectedStudentId) {
            return null;
        }

        return User::with([
            'studentProfile',
            'feeVouchers' => function($query) {
                $query->orderByRaw("FIELD(status, 'unpaid', 'partial', 'paid', 'cancelled')")->orderBy('due_date', 'desc');
            },
            'feeVouchers.class',
            'feeVouchers.items',
            'feeVouchers.payments' => function($query) {
                $query->orderByDesc('paid_at');
            },
        ])->findOrFail($this->selectedStudentId);
    }

    #[Computed]
    public function classes()
    {
        return \App\Models\Classes::orderBy('numeric_value')->get();
    }

    public function render()
    {
        return view('livewire.admin.fee-collection');
    }
}
