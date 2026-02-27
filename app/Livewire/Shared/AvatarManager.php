<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AvatarManager extends Component
{
    use WithFileUploads;

    public User $user;
    public $photo;

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);

        if ($this->user->avatar_path && Storage::disk('public')->exists($this->user->avatar_path)) {
            Storage::disk('public')->delete($this->user->avatar_path);
        }

        $path = $this->photo->store('avatars', 'public');
        
        $this->user->update(['avatar_path' => $path]);

        $this->reset('photo');
        
        session()->flash('avatar_success', 'Photo updated!');
        $this->dispatch('avatar-updated');
    }

    public function delete()
    {
        if ($this->user->avatar_path && Storage::disk('public')->exists($this->user->avatar_path)) {
            Storage::disk('public')->delete($this->user->avatar_path);
        }
        
        $this->user->update(['avatar_path' => null]);
        session()->flash('avatar_success', 'Photo removed.');
        $this->dispatch('avatar-updated');
    }

    public function render()
    {
        return view('livewire.shared.avatar-manager');
    }
}