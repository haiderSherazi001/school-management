<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Designation;

#[Layout('layouts.app')]
class StaffDirectory extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'active';
    public $designationFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDesignationFilter()
    {
        $this->resetPage();
    }

    public function setFilter($status)
    {
        $this->statusFilter = $status;
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
                                   ->orWhereHas('designation', function ($desigQuery) {
                                       $desigQuery->where('title', 'like', '%' . $this->search . '%');
                                   });
                      });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->whereHas('staffProfile', function ($subQuery) {
                    $subQuery->where('employment_status', $this->statusFilter);
                });
            })
            ->when($this->designationFilter !== '', function ($query) {
                $query->whereHas('staffProfile', function ($subQuery) {
                    $subQuery->where('designation_id', $this->designationFilter);
                });
            })
            ->with(['staffProfile.designation'])
            ->latest()
            ->paginate(10);

        return view('livewire.staff.staff-directory', [
            'staffMembers' => $staffMembers,
            'designations' => Designation::where('is_active', true)->orderBy('title')->get()
        ]);
    }
}