<div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Document Center</h3>

    @if (session()->has('success'))
        <div wire:ignore x-data="{ show: true }" x-show="show" class="mb-5 rounded-md bg-green-50 p-3 border border-green-200 text-sm font-medium text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="flex flex-col md:flex-row gap-4 mb-6 items-end">
        <div class="flex-1 w-full">
            <label class="block text-sm font-medium text-gray-700">Document Title</label>
            <input type="text" wire:model="title" placeholder="e.g., B-Form, Resume, Previous Result" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex-1 w-full">
            <label class="block text-sm font-medium text-gray-700">Select File (Max 5MB)</label>
            <input type="file" wire:model="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
            @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="w-full md:w-auto">
            <button type="submit" wire:loading.attr="disabled" class="w-full md:w-auto rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition h-[38px] flex items-center justify-center">
                <span wire:loading.remove wire:target="save" class="text-white">Upload</span>
                <span wire:loading wire:target="save" class="text-white">Uploading...</span>
            </button>
        </div>
    </form>

    <div class="border-t border-gray-200 pt-4">
        @if($documents->isEmpty())
            <p class="text-sm text-gray-500 text-center py-6 bg-gray-50 rounded border border-dashed border-gray-300">No documents uploaded yet.</p>
        @else
            <ul class="divide-y divide-gray-100">
                @foreach($documents as $doc)
                    <li class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded bg-indigo-50 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase tracking-wider">
                                {{ $doc->file_type }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $doc->title }}</p>
                                <p class="text-xs font-medium text-gray-500">Uploaded on {{ $doc->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900 transition">View</a>
                            
                            <button type="button" wire:click="delete({{ $doc->id }})" wire:confirm="Are you sure you want to delete this document?" class="text-sm font-semibold text-red-600 hover:text-red-900 transition">Delete</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>