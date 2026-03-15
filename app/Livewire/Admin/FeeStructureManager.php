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
    public $cloneFromSession = '';
    public $cloneToSession = '';

    public function cloneStructure()
    {
        $this->validate([
            'cloneFromSession' => 'required|string',
            'cloneToSession' => 'required|string|different:cloneFromSession',
        ]);
        $oldFees = FeeStructure::where('academic_session', $this->cloneFromSession)->get();

        if ($oldFees->isEmpty()) {
            session()->flash('error', "No fee structures found in the {$this->cloneFromSession} session to copy!");
            return;
        }

        $count = 0;

        foreach ($oldFees as $oldFee) {
            
            FeeStructure::updateOrCreate(
                [
                    'class_id' => $oldFee->class_id,
                    'academic_session' => $this->cloneToSession,
                ],
                [
                    'tuition_fee' => $oldFee->tuition_fee,
                ]
            );
            $count++;
        }

        $this->cloneFromSession = '';
        $this->cloneToSession = '';

        session()->flash('success', "Successfully copied {$count} class fee structures to the {$this->cloneToSession} session!");
    }

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
        
        return FeeStructure::with('class')
            ->where('academic_session', $currentSession)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.fee-structure-manager', [
            'classes' => Classes::orderBy('numeric_value')->get(),
            'currentSession' => Setting::get('current_session', date('Y') . '-' . (date('Y') + 1)),
        ]);
    }
}