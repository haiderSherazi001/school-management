<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Classes;
use App\Models\StudentProfile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

#[Layout('layouts.app')]
class CreateStudent extends Component
{
    // Base User Details
    public $name = '';
    public $email = '';

    // Academic Details
    public $class_id = '';
    public $admission_date = '';

    // Personal Details
    public $cnic = '';
    public $date_of_birth = '';
    public $gender = 'male';
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
            'email' => 'nullable|email', 
            'class_id' => 'required|exists:classes,id',
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

        // 1. Auto-Generate the Roll Number (e.g., STD-2026-00001)
        $latestProfile = StudentProfile::latest('id')->first();
        $nextId = $latestProfile ? $latestProfile->id + 1 : 1;
        $generatedRollNumber = 'STD-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        // 2. Auto-Generate Password based on Date of Birth (e.g., dob-20150825)
        $cleanDob = Carbon::parse($this->date_of_birth)->format('Ymd');
        $generatedPassword = 'dob-' . $cleanDob;

        // 3. Create the Login Account (Username = Roll Number)
        $user = User::create([
            'name' => $this->name,
            'username' => $generatedRollNumber,
            'email' => $this->email ?: null,
            'password' => Hash::make($generatedPassword), 
        ]);

        // 4. Assign the Spatie Role
        $role = Role::firstOrCreate(['name' => 'Student']);
        $user->assignRole($role);

        // 5. Create the Student Profile
        $user->studentProfile()->create([
            'class_id' => $this->class_id,
            'roll_number' => $generatedRollNumber, 
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

        session()->flash('success', "Student admitted successfully! Login Username: {$generatedRollNumber} | Password: {$generatedPassword}");

        return $this->redirectRoute('students.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.create-student', [
            'classes' => Classes::orderBy('numeric_value')->get()
        ]);
    }
}