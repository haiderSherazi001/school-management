<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Staff\StaffDirectory;
use App\Livewire\Staff\CreateStaff;
use App\Livewire\Staff\EditStaff;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    
    Route::get('/staff/create', CreateStaff::class)->name('staff.create');
    Route::get('/staff/{staff}/edit', EditStaff::class)->name('staff.edit');
    Route::get('/staff', StaffDirectory::class)->name('staff.index');

});

require __DIR__.'/auth.php';