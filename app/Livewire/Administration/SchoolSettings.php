<?php

namespace App\Livewire\Administration;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Setting;

#[Layout('layouts.app')]
class SchoolSettings extends Component
{
    public $school_name;
    public $school_email;
    public $school_phone;
    public $school_address;
    public $current_session;
    
    // Array to hold our dynamic years
    public $availableSessions = [];

    public function mount()
    {
        $this->loadSettings();
        $this->generateSessions();
    }

    // Extracted so we can reuse it for the "Cancel" button
    public function loadSettings()
    {
        $this->school_name = Setting::get('school_name', 'My School Academy');
        $this->school_email = Setting::get('school_email', 'admin@school.com');
        $this->school_phone = Setting::get('school_phone', '');
        $this->school_address = Setting::get('school_address', '');
        
        // Default to current year if nothing is set
        $defaultSession = date('Y') . '-' . (date('Y') + 1);
        $this->current_session = Setting::get('current_session', $defaultSession);
    }

    public function generateSessions()
    {
        $currentYear = (int) date('Y');
        
        for ($i = -2; $i <= 2; $i++) {
            $startYear = $currentYear + $i;
            $endYear = $startYear + 1;
            $this->availableSessions[] = "$startYear-$endYear";
        }
    }

    public function cancel()
    {
        $this->loadSettings();
    }

    public function save()
    {
        $this->validate([
            'school_name' => 'required|string|max:255',
            'school_email' => 'required|email|max:255',
            'school_phone' => 'nullable|string|max:20',
            'school_address' => 'nullable|string|max:500',
            'current_session' => 'required|string|max:20',
        ]);

        Setting::set('school_name', $this->school_name, 'general');
        Setting::set('school_email', $this->school_email, 'general');
        Setting::set('school_phone', $this->school_phone, 'general');
        Setting::set('school_address', $this->school_address, 'general');
        Setting::set('current_session', $this->current_session, 'academic');
        
        $this->dispatch('settings-saved', message: 'School settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.administration.school-settings');
    }
}