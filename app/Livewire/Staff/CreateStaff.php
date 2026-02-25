<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Models\User;
use App\Models\StaffProfile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
class CreateStaff extends Component
{
    public function mount()
    {
        $this->joining_date = now()->format('Y-m-d');
    }

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('nullable|email|unique:users,email')]
    public $email = '';

    #[Validate('required|digits:13|unique:staff_profiles,cnic')]
    public $cnic = '';

    #[Validate('required|string')]
    public $designation = '';

    #[Validate('required|string')]
    public $qualification = '';

    #[Validate('required|string|max:11')]
    public $phone = '';

    #[Validate('required|numeric|min:0')]
    public $salary = '';

    #[Validate('required|date')]
    public $joining_date = '';

    #[Validate('required|in:male,female,other')]
    public $gender = 'male';

    #[Validate('required|string')]
    public $address = '';

    public function save()
    {
        $this->validate(); 

        $latestProfile = StaffProfile::latest('id')->first();
        $nextId = $latestProfile ? $latestProfile->id + 1 : 1;
        $generatedStaffId = 'STF-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        $generatedPassword = 'cnic-' . $this->cnic;

        $user = User::create([
            'name' => $this->name,
            'username' => $generatedStaffId,
            'email' => $this->email ?: null,
            'password' => Hash::make($generatedPassword), 
        ]);

        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $user->assignRole($staffRole);

        $user->staffProfile()->create([
            'cnic' => $this->cnic,
            'designation' => $this->designation,
            'qualification' => $this->qualification,
            'phone' => $this->phone,
            'salary' => $this->salary,
            'joining_date' => $this->joining_date,
            'gender' => $this->gender,
            'address' => $this->address,
        ]);

        session()->flash('success', "Staff added successfully! Login Username: {$generatedStaffId} | Password: {$generatedPassword}");

        return $this->redirectRoute('staff.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.staff.create-staff');
    }
}