<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\FeeVoucher;
use App\Models\Enrollment;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Layout('layouts.app')]
class BulkFeeGenerator extends Component
{
    public $billing_month;
    public $due_date;
    public $target_class_id = '';
    
    public $customItems = [];

    public function mount()
    {
        $this->billing_month = date('Y-m'); 
        $this->due_date = date('Y-m-10');
    }

    public function generateVouchers()
    {
        $this->validate([
            'billing_month' => 'required|date_format:Y-m',
            'due_date' => 'required|date',
            'target_class_id' => 'nullable|exists:classes,id',
            'customItems.*.title' => 'required|string|max:255',
            'customItems.*.amount' => 'required|numeric|min:1',
        ]);

        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        $formattedMonth = Carbon::createFromFormat('Y-m', $this->billing_month)->format('F Y');

        $feeQuery = FeeStructure::where('academic_session', $currentSession);
        if ($this->target_class_id) {
            $feeQuery->where('class_id', $this->target_class_id);
        }
        $feeStructures = $feeQuery->get()->keyBy('class_id'); 

        if ($feeStructures->isEmpty()) {
            session()->flash('error', 'No Fee Structures found! Please define class fees first.');
            return;
        }

        $enrollments = Enrollment::with(['student.studentProfile'])
            ->where('academic_session', $currentSession)
            ->whereIn('class_id', $feeStructures->keys())
            ->whereHas('student.studentProfile', function($query) {
                $query->where('status', 'active');
            })
            ->get();

        $generatedCount = 0;
        $skippedCount = 0;

        $customTotal = collect($this->customItems)->sum('amount');

        DB::transaction(function () use ($enrollments, $feeStructures, $currentSession, $formattedMonth, $customTotal, &$generatedCount, &$skippedCount) {
            foreach ($enrollments as $enrollment) {
                
                $exists = FeeVoucher::where('user_id', $enrollment->user_id)
                    ->where('academic_session', $currentSession)
                    ->where('billing_month', $formattedMonth)
                    ->exists();

                if ($exists) {
                    $skippedCount++;
                    continue;
                }

                $voucherNumber = 'FV-' . date('Ym') . '-' . str_pad($enrollment->user_id, 4, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
                
                $tuitionAmount = $feeStructures[$enrollment->class_id]->tuition_fee;
                $grandTotal = $tuitionAmount + $customTotal;

                $voucher = FeeVoucher::create([
                    'voucher_number' => $voucherNumber,
                    'user_id' => $enrollment->user_id,
                    'class_id' => $enrollment->class_id,
                    'academic_session' => $currentSession,
                    'billing_month' => $formattedMonth,
                    'amount' => $grandTotal,
                    'due_date' => $this->due_date,
                    'status' => 'unpaid',
                ]);

                $voucher->items()->create([
                    'title' => 'Monthly Tuition Fee',
                    'amount' => $tuitionAmount,
                ]);

                foreach ($this->customItems as $customItem) {
                    // Safety check to ensure empty rows from Alpine aren't saved
                    if(!empty($customItem['title']) && !empty($customItem['amount'])) {
                        $voucher->items()->create([
                            'title' => $customItem['title'],
                            'amount' => $customItem['amount'],
                        ]);
                    }
                }

                $generatedCount++;
            }
        });

        session()->flash('success', "Success! Generated {$generatedCount} new itemized vouchers. Skipped {$skippedCount} students who were already billed.");
        
        $this->customItems = [];
    }

    public function render()
    {
        return view('livewire.admin.bulk-fee-generator', [
            'classes' => Classes::orderBy('numeric_value')->get(),
        ]);
    }
}