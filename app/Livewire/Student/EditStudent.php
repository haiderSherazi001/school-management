<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class EditStudent extends Component
{
    public User $student;

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
    public $gender = '';
    public $blood_group = '';
    public $personal_phone = '';
    public $personal_email = '';

    // Guardian Details
    public $guardian_name = '';
    public $guardian_phone = '';
    public $guardian_email = '';
    public $address = '';

    public function mount(User $student)
    {
        $this->student = $student;

        // Load Base User Info
        $this->name = $student->name;
        $this->email = $student->email;

        // Load Profile Info
        $profile = $student->studentProfile;
        if ($profile) {
            $this->admission_date = $profile->admission_date;
            $this->cnic = $profile->cnic;
            $this->roll_number = $profile->roll_number;
            $this->date_of_birth = $profile->date_of_birth;
            $this->gender = $profile->gender;
            $this->blood_group = $profile->blood_group;
            $this->personal_phone = $profile->personal_phone;
            $this->personal_email = $profile->personal_email;
            $this->guardian_name = $profile->guardian_name;
            $this->guardian_phone = $profile->guardian_phone;
            $this->guardian_email = $profile->guardian_email;
            $this->address = $profile->address;
        }

        $this->class_id = $student->currentClass()?->id;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email', 
            'class_id' => 'required|exists:classes,id',
            'admission_date' => 'required|date',
            'cnic' => 'required|string|unique:student_profiles,cnic,' . $this->student->studentProfile->id,
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

        DB::transaction(function () {
            
            // 1. Update Base User
            $this->student->update([
                'name' => $this->name,
                'email' => $this->email ?: null,
            ]);

            // 2. Update Student Profile (No class_id here!)
            $this->student->studentProfile()->update([
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

            // 3. Update or Create the Enrollment
            $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
            
            Enrollment::updateOrCreate(
                [
                    'user_id' => $this->student->id,
                    'academic_session' => $currentSession,
                ],
                [
                    'class_id' => $this->class_id,
                ]
            );

        });

        session()->flash('success', 'Student profile updated successfully!');

        return $this->redirectRoute('students.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.edit-student', [
            'classes' => Classes::orderBy('numeric_value')->get()
        ]);
    }
}