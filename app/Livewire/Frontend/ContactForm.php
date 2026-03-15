<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Lead;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $institution = '';
    public $message = '';
    
    public $successMessage = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'institution' => 'nullable|string|max:255',
        'message' => 'required|string|max:1000',
    ];

    public function submit()
    {
        $this->validate();

        Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'institution' => $this->institution,
            'message' => $this->message,
            'status' => 'new'
        ]);

        $this->reset(['name', 'email', 'institution', 'message']);
        $this->successMessage = true;
    }

    public function render()
    {
        return view('livewire.frontend.contact-form');
    }
}
