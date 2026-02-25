<?php
namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

#[Layout('layouts.app')]
class EditStaff extends Component
{
    public User $staff; 

    public $name = '';
    public $email = '';
    public $cnic = '';
    public $designation = '';
    public $qualification = '';
    public $phone = '';
    public $salary = '';
    public $joining_date = '';
    public $gender = 'male';
    public $address = '';

    public function mount(User $staff)
    {
        $this->staff = $staff;

        $this->name = $staff->name;
        $this->email = $staff->email;

        $profile = $staff->staffProfile;
        if ($profile) {
            $this->cnic = $profile->cnic;
            $this->designation = $profile->designation;
            $this->qualification = $profile->qualification;
            $this->phone = $profile->phone;
            $this->salary = $profile->salary;
            $this->joining_date = $profile->joining_date;
            $this->gender = $profile->gender;
            $this->address = $profile->address;
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->staff->id,
            'cnic' => 'required|string|max:13|unique:staff_profiles,cnic,' . $this->staff->staffProfile->id,
            'designation' => 'required|string',
            'qualification' => 'required|string',
            'phone' => 'required|string|max:11',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
        ]);

        $this->staff->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->staff->staffProfile()->update([
            'cnic' => $this->cnic,
            'designation' => $this->designation,
            'qualification' => $this->qualification,
            'phone' => $this->phone,
            'salary' => $this->salary,
            'joining_date' => $this->joining_date,
            'gender' => $this->gender,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Staff member updated successfully!');

        return $this->redirectRoute('staff.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.staff.edit-staff');
    }
}