<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class StaffDirectory extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $staff = User::findOrFail($id);
        
        if ($staff->staffProfile) {
            $staff->staffProfile->delete();
        }
        
        $staff->delete();

        session()->flash('success', 'Staff member removed successfully!');
    }
    public function render()
    {
        $staffMembers = User::role('Staff')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhereHas('staffProfile', function ($subQuery) {
                          $subQuery->where('cnic', 'like', '%' . $this->search . '%')
                                   ->orWhere('phone', 'like', '%' . $this->search . '%')
                                   ->orWhere('designation', 'like', '%' . $this->search . '%');
                      });
            })
            ->with('staffProfile')
            ->paginate(10);

        return view('livewire.staff.staff-directory', [
            'staffMembers' => $staffMembers
        ]);
    }
}