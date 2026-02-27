<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Classes;
use App\Models\StudentProfile;
use App\Models\Enrollment;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        // We find the latest user ID to ensure a unique roll number. We use User ID instead of StudentProfile ID because the Username is stored in the User table.
        $latestUser = User::latest('id')->first();
        $nextId = $latestUser ? $latestUser->id + 1 : 1;
        $generatedRollNumber = 'STD-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        // 2. Auto-Generate Password based on Date of Birth (e.g., dob-20150825)
        $cleanDob = Carbon::parse($this->date_of_birth)->format('Ymd');
        $generatedPassword = 'dob-' . $cleanDob;

        // Wrap the database inserts in a Transaction for safety
        DB::transaction(function () use ($generatedRollNumber, $generatedPassword) {
            
            $user = User::create([
                'name' => $this->name,
                'username' => $generatedRollNumber,
                'email' => $this->email ?: null,
                'password' => Hash::make($generatedPassword), 
            ]);

            $role = Role::firstOrCreate(['name' => 'Student']);
            $user->assignRole($role);

            $user->studentProfile()->create([
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

            $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
            
            Enrollment::create([
                'user_id' => $user->id,
                'class_id' => $this->class_id,
                'academic_session' => $currentSession,
            ]);

        });

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