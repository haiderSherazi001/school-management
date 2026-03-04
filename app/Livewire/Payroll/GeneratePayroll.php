<?php

namespace App\Livewire\Payroll;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Payslip;
use Carbon\Carbon;

#[Layout('layouts.app')]
class GeneratePayroll extends Component
{
    public $billing_month;

    public $editingPayslipId = null;
    public $staffName = '';
    public $edit_base_salary = 0;
    public $edit_bonuses = 0;
    public $edit_deductions = 0;
    public $edit_net_payable = 0;

    public function mount()
    {
        $this->billing_month = Carbon::now()->format('Y-m');
    }

    public function generate()
    {
        $this->validate([
            'billing_month' => 'required|date_format:Y-m',
        ]);

        $activeStaff = User::role('Staff')
            ->whereHas('staffProfile', function ($query) {
                $query->where('employment_status', 'active');
            })
            ->with('staffProfile')
            ->get();

        if ($activeStaff->isEmpty()) {
            session()->flash('error', 'No active staff members found to generate payroll.');
            return;
        }

        $generatedCount = 0;

        foreach ($activeStaff as $staff) {
            $baseSalary = $staff->staffProfile->salary ?? 0;

            $payslip = Payslip::firstOrCreate(
                [
                    'user_id' => $staff->id,
                    'billing_month' => $this->billing_month,
                ],
                [
                    'base_salary' => $baseSalary,
                    'bonuses' => 0,
                    'deductions' => 0,
                    'net_payable' => $baseSalary,
                    'status' => 'pending',
                ]
            );

            if ($payslip->wasRecentlyCreated) {
                $generatedCount++;
            }
        }

        if ($generatedCount > 0) {
            session()->flash('success', "Successfully generated {$generatedCount} new payslips!");
        } else {
            session()->flash('info', 'All active staff members already have payslips generated for this month.');
        }
    }

    public function editDraft($id)
    {
        $payslip = Payslip::with('staff')->findOrFail($id);
        
        $this->editingPayslipId = $payslip->id;
        $this->staffName = $payslip->staff->name;
        $this->edit_base_salary = $payslip->base_salary;
        $this->edit_bonuses = $payslip->bonuses;
        $this->edit_deductions = $payslip->deductions;
        $this->edit_net_payable = $payslip->net_payable;
    }

    public function updatedEditBonuses()
    {
        $this->calculateNet();
    }

    public function updatedEditDeductions()
    {
        $this->calculateNet();
    }

    private function calculateNet()
    {
        $bonuses = is_numeric($this->edit_bonuses) ? $this->edit_bonuses : 0;
        $deductions = is_numeric($this->edit_deductions) ? $this->edit_deductions : 0;
        
        $this->edit_net_payable = $this->edit_base_salary + $bonuses - $deductions;
    }

    public function saveDraft()
    {
        $this->validate([
            'edit_bonuses' => 'required|numeric|min:0',
            'edit_deductions' => 'required|numeric|min:0',
        ]);

        $payslip = Payslip::findOrFail($this->editingPayslipId);
        $payslip->update([
            'bonuses' => $this->edit_bonuses,
            'deductions' => $this->edit_deductions,
            'net_payable' => $this->edit_net_payable,
        ]);

        session()->flash('success', 'Payslip adjusted successfully.');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->reset(['editingPayslipId', 'staffName', 'edit_base_salary', 'edit_bonuses', 'edit_deductions', 'edit_net_payable']);
    }

    public function markAsPaid($id)
    {
        $payslip = Payslip::findOrFail($id);
        $payslip->update([
            'status' => 'paid',
            'paid_at' => Carbon::now(),
        ]);

        session()->flash('success', 'Payslip marked as Paid!');
    }

    public function markAllAsPaid()
    {
        $pendingSlips = Payslip::where('billing_month', $this->billing_month)
            ->where('status', 'pending');

        $count = $pendingSlips->count();

        if ($count > 0) {
            $pendingSlips->update([
                'status' => 'paid',
                'paid_at' => Carbon::now(),
            ]);

            session()->flash('success', "Success! {$count} payslips have been officially marked as PAID.");
        } else {
            session()->flash('info', 'There are no pending payslips to mark as paid for this month.');
        }
    }

    public function render()
    {
        $payslips = Payslip::where('billing_month', $this->billing_month)
            ->with(['staff.staffProfile.designation'])
            ->latest()
            ->get();

        return view('livewire.payroll.generate-payroll', [
            'payslips' => $payslips
        ]);
    }
}