<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\Setting;

#[Layout('layouts.app')]
class FeeStructureManager extends Component
{
    public $class_id = '';
    public $tuition_fee = '';
    public $isEditing = false;

    public function save()
    {
        $this->validate([
            'class_id' => 'required|exists:classes,id',
            'tuition_fee' => 'required|integer|min:0',
        ]);

        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));

        FeeStructure::updateOrCreate(
            ['class_id' => $this->class_id, 'academic_session' => $currentSession],
            ['tuition_fee' => $this->tuition_fee]
        );

        $this->reset(['class_id', 'tuition_fee', 'isEditing']);
        unset($this->feeStructures); 
        
        session()->flash('success', 'Fee structure saved successfully!');
    }

    #[Computed]
    public function feeStructures()
    {
        $currentSession = Setting::get('current_session', date('Y') . '-' . (date('Y') + 1));
        
        return FeeStructure::with('academicClass')
            ->where('academic_session', $currentSession)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.fee-structure-manager', [
            'classes' => Classes::orderBy('numeric_value')->get(),
        ]);
    }
}