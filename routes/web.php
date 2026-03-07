<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Staff\StaffDirectory;
use App\Livewire\Staff\CreateStaff;
use App\Livewire\Staff\EditStaff;
use App\Livewire\Academic\ManageClasses;
use App\Livewire\Student\StudentDirectory;
use App\Livewire\Student\CreateStudent;
use App\Livewire\Student\EditStudent;
use App\Livewire\Student\ShowStudent;
use App\Livewire\Staff\ShowStaff;
use App\Livewire\Staff\Portal as StaffPortal;
use App\Livewire\Student\Portal as StudentPortal;
use App\Livewire\Administration\SchoolSettings;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\BulkEnrollment;
use App\Livewire\Admin\BulkGraduation;
use App\Livewire\Admin\FeeStructureManager;
use App\Livewire\Admin\BulkFeeGenerator;
use App\Livewire\Admin\FeeCollection;
use App\Http\Controllers\Admin\FeeVoucherPrintController;
use App\Livewire\Admin\DesignationManager;
use App\Livewire\Payroll\GeneratePayroll;
use App\Livewire\Admin\Finance\ExpenseManager;
use App\Livewire\Admin\Finance\IncomeManager;
use App\Livewire\Admin\Reports\FinancialLedger;
use App\Models\Payslip;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
});

Route::middleware(['auth', 'role:Staff'])->group(function () {
    Route::get('/staff/portal', StaffPortal::class)->name('staff.portal');
});

Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/student/portal', StudentPortal::class)->name('student.portal');
});

Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/students/bulk-enroll', BulkEnrollment::class)->name('students.bulk-enroll');
    Route::get('/students/bulk-graduate', BulkGraduation::class)->name('students.bulk-graduate');

    Route::get('/reports/financial-ledger', FinancialLedger::class)->name('reports.financial');

    Route::get('/hr/attendance', \App\Livewire\Admin\HR\StaffAttendance::class)->name('hr.attendance');

    Route::get('/finance/expenses', ExpenseManager::class)->name('finance.expenses');
    Route::get('/finance/income', IncomeManager::class)->name('finance.income');

    Route::get('/fees/structure', FeeStructureManager::class)->name('fees.structure');
    Route::get('/fees/generate', BulkFeeGenerator::class)->name('fees.generate');
    Route::get('/fees/collect', FeeCollection::class)->name('fees.collect');
    Route::get('/fees/voucher/{id}/print', [FeeVoucherPrintController::class, 'show'])->name('fees.print');

    Route::get('/payroll/generate', GeneratePayroll::class)->name('payroll.generate');
    Route::get('/payroll/print/{id}', function ($id) {
        $payslip = Payslip::with('staff.staffProfile.designation')->findOrFail($id);
        return view('admin.payroll.print', compact('payslip'));
    })->name('payroll.print');

    Route::get('/classes', ManageClasses::class)->name('classes.index');
    Route::get('/settings', SchoolSettings::class)->name('settings.index'); 
    
    Route::get('/students/create', CreateStudent::class)->name('students.create');
    Route::get('/students/{student}/edit', EditStudent::class)->name('students.edit');
    Route::get('/students/{student}', ShowStudent::class)->name('students.show');
    Route::get('/students', StudentDirectory::class)->name('students.index');  

    Route::get('/staff/designations', DesignationManager::class)->name('staff.designations');
    Route::get('/staff/create', CreateStaff::class)->name('staff.create');
    Route::get('/staff/{staff}/edit', EditStaff::class)->name('staff.edit');
    Route::get('/staff/{staff}', ShowStaff::class)->name('staff.show');
    Route::get('/staff', StaffDirectory::class)->name('staff.index');
});

require __DIR__.'/auth.php';