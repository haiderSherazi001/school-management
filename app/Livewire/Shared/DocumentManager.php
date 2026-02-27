<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentManager extends Component
{
    use WithFileUploads;

    public Model $model; 

    public $title = '';
    public $file;

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:5120',
        ]);

        $path = $this->file->store('documents', 'public');

        $this->model->documents()->create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'file_path' => $path,
            'file_type' => $this->file->getClientOriginalExtension(),
        ]);

        $this->reset(['title', 'file']);
        
        session()->flash('success', 'Document uploaded successfully!');
    }

    public function delete($documentId)
    {
        $document = Document::findOrFail($documentId);
        
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();
        
        session()->flash('success', 'Document removed.');
    }

    public function render()
    {
        return view('livewire.shared.document-manager', [
            'documents' => $this->model->documents()->latest()->get()
        ]);
    }
}