<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Models\User;
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

    #[Validate('required|email|unique:users,email')]
    public $email = '';

    #[Validate('required|digits:13|unique:staff_profiles,cnic')]
    public $cnic = '';

    #[Validate('required|string')]
    public $designation = '';

    #[Validate('required|string')]
    public $qualification = '';

    #[Validate('required|string')]
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

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('password123'), 
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

        session()->flash('success', 'Staff member created successfully!');

        return $this->redirectRoute('staff.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.staff.create-staff');
    }
}