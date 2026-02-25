<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Classes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.app')]
class CreateStudent extends Component
{
    // Base User Details
    public $name = '';
    public $email = '';

    // Academic Details
    public $class_id = '';
    public $roll_number = '';
    public $admission_date = '';

    // Personal Details
    public $cnic = '';
    public $date_of_birth = '';
    public $gender = 'Male';
    public $blood_group = '';
    public $personal_phone = '';
    public $personal_email = '';

    // Guardian Details
    public $guardian_name = '';
    public $guardian_phone = '';
    public $guardian_email = '';
    public $address = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'class_id' => 'required|exists:classes,id',
            'roll_number' => 'required|string|unique:student_profiles,roll_number',
            'admission_date' => 'required|date',
            'cnic' => 'required|string|unique:student_profiles,cnic',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:255',
            'address' => 'required|string',
            'blood_group' => 'nullable|string',
            'personal_phone' => 'nullable|string',
            'personal_email' => 'nullable|email',
            'guardian_email' => 'nullable|email',
        ]);

        // 1. Create the Login Account
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('password123')
        ]);

        // 2. Assign the Spatie Role
        $role = Role::firstOrCreate(['name' => 'Student']);
        $user->assignRole($role);

        // 3. Create the massive Student Profile
        $user->studentProfile()->create([
            'class_id' => $this->class_id,
            'roll_number' => $this->roll_number,
            'admission_date' => $this->admission_date,
            'cnic' => $this->cnic,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'blood_group' => $this->blood_group,
            'personal_phone' => $this->personal_phone,
            'personal_email' => $this->personal_email,
            'guardian_name' => $this->guardian_name,
            'guardian_phone' => $this->guardian_phone,
            'guardian_email' => $this->guardian_email,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Student admitted successfully!');

        return $this->redirectRoute('students.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.create-student', [
            'classes' => Classes::orderBy('numeric_value')->get()
        ]);
    }
}