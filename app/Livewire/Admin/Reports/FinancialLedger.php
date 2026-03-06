<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\FeeVoucher;
use App\Models\Payslip;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;

#[Layout('layouts.app')]
class FinancialLedger extends Component
{
    public $selectedYear;

    public function mount()
    {
        $this->selectedYear = date('Y');
    }

    public function render()
    {
        $monthlyData = [];
        $totalFeeRevenue = 0;
        $totalGeneralIncome = 0;
        $totalPayroll = 0;
        $totalGeneralExpenses = 0;

        for ($i = 1; $i <= 12; $i++) {
            
            $dbMonthString = $this->selectedYear . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            
            $feeVoucherMonthString = Carbon::create($this->selectedYear, $i, 1)->format('F Y');

            $feeRevenue = FeeVoucher::where('billing_month', $feeVoucherMonthString)
                                 ->where('status', 'paid')
                                 ->sum('amount');

            $generalIncome = Income::where('income_date', 'like', $dbMonthString . '%')
                                   ->sum('amount');

            $payroll = Payslip::where('billing_month', 'like', $dbMonthString . '%')
                              ->where('status', 'paid')
                              ->sum('net_payable');

            $generalExpense = Expense::where('expense_date', 'like', $dbMonthString . '%')
                                     ->sum('amount');

            $totalMonthRevenue = $feeRevenue + $generalIncome;
            $totalMonthExpense = $payroll + $generalExpense;
            $profit = $totalMonthRevenue - $totalMonthExpense;

            $monthlyData[] = [
                'month_name' => Carbon::create($this->selectedYear, $i, 1)->format('F'),
                'fee_revenue' => $feeRevenue,
                'general_income' => $generalIncome,
                'total_revenue' => $totalMonthRevenue,
                'payroll' => $payroll,
                'general_expense' => $generalExpense,
                'total_expense' => $totalMonthExpense,
                'profit' => $profit
            ];

            $totalFeeRevenue += $feeRevenue;
            $totalGeneralIncome += $generalIncome;
            $totalPayroll += $payroll;
            $totalGeneralExpenses += $generalExpense;
        }

        $totalCombinedRevenue = $totalFeeRevenue + $totalGeneralIncome;
        $totalCombinedExpenses = $totalPayroll + $totalGeneralExpenses;

        return view('livewire.admin.reports.financial-ledger', [
            'monthlyData' => $monthlyData,
            'totalFeeRevenue' => $totalFeeRevenue,
            'totalGeneralIncome' => $totalGeneralIncome,
            'totalRevenue' => $totalCombinedRevenue,
            'totalPayroll' => $totalPayroll,
            'totalGeneralExpenses' => $totalGeneralExpenses,
            'totalExpenses' => $totalCombinedExpenses,
            'netProfit' => $totalCombinedRevenue - $totalCombinedExpenses,
        ]);
    }
}