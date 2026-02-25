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

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    Route::get('/classes', ManageClasses::class)->name('classes.index');

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