<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Models\User;
use App\Models\StaffProfile;
use App\Models\Designation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class CreateStaff extends Component
{
    public function mount()
    {
        $this->joining_date = now()->format('Y-m-d');
        $this->employment_status = 'active'; 
    }

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('nullable|email|unique:users,email')]
    public $email = '';

    #[Validate('required|digits:13|unique:staff_profiles,cnic')]
    public $cnic = '';

    #[Validate('required|exists:designations,id')]
    public $designation_id = '';

    #[Validate('required|in:active,on_leave,resigned,terminated')]
    public $employment_status = 'active';

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

        $nextId = 1;
        do {
            $generatedStaffId = 'STF-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            $idExists = DB::table('users')->where('username', $generatedStaffId)->exists();
            if ($idExists) {
                $nextId++;
            }
        } while ($idExists);

        $generatedPassword = 'cnic-' . $this->cnic;

        DB::transaction(function () use ($generatedStaffId, $generatedPassword) {
            
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
                'designation_id' => $this->designation_id, 
                'employment_status' => $this->employment_status, 
                'qualification' => $this->qualification,
                'phone' => $this->phone,
                'salary' => $this->salary,
                'joining_date' => $this->joining_date,
                'gender' => $this->gender,
                'address' => $this->address,
            ]);
            
        });

        session()->flash('success', "Staff added successfully! Login Username: {$generatedStaffId} | Password: {$generatedPassword}");

        return $this->redirectRoute('staff.index', navigate: true);
    }
    public function updatedDesignationId($value)
    {
        if ($value) {
            $designation = Designation::find($value);
            if ($designation) {
                $this->salary = $designation->default_salary; 
            }
        } else {
            $this->salary = ''; 
        }
    }

    public function render()
    {
        return view('livewire.staff.create-staff', [
            'designations' => Designation::where('is_active', true)
                                         ->orderBy('department')
                                         ->orderBy('title')
                                         ->get()
        ]);
    }
}