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
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/classes', ManageClasses::class)->name('classes.index');
    Route::get('/settings', SchoolSettings::class)->name('settings.index'); 
    
    Route::get('/students/create', CreateStudent::class)->name('students.create');
    Route::get('/students/{student}/edit', EditStudent::class)->name('students.edit');
    Route::get('/students/{student}', ShowStudent::class)->name('students.show');
    Route::get('/students', StudentDirectory::class)->name('students.index');  

    Route::get('/staff/create', CreateStaff::class)->name('staff.create');
    Route::get('/staff/{staff}/edit', EditStaff::class)->name('staff.edit');
    Route::get('/staff/{staff}', ShowStaff::class)->name('staff.show');
    Route::get('/staff', StaffDirectory::class)->name('staff.index');
});

require __DIR__.'/auth.php';