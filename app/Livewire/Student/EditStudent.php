<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Classes;

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
    public $gender = 'male';
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

        // Pre-fill base User details
        $this->name = $student->name;
        $this->email = $student->email;

        // Pre-fill Profile details
        $profile = $student->studentProfile;
        if ($profile) {
            $this->class_id = $profile->class_id;
            $this->roll_number = $profile->roll_number;
            $this->admission_date = $profile->admission_date;
            $this->cnic = $profile->cnic;
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
    }

    public function update()
    {
        $profileId = $this->student->studentProfile->id;

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->student->id,
            'class_id' => 'required|exists:classes,id',
            'cnic' => 'required|string|unique:student_profiles,cnic,' . $profileId,
            'admission_date' => 'required|date',
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

        // Update User (Notice we do NOT update username/password here)
        $this->student->update([
            'name' => $this->name,
            'email' => $this->email ?: null,
        ]);

        // Update Profile (Notice we do NOT update roll_number here)
        $this->student->studentProfile()->update([
            'class_id' => $this->class_id,
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

        session()->flash('success', 'Student record updated successfully!');

        return $this->redirectRoute('students.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.edit-student', [
            'classes' => Classes::orderBy('numeric_value')->get()
        ]);
    }
}