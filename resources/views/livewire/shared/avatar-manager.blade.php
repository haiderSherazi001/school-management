<div class="flex flex-col items-center sm:items-start gap-3">
    
    <div class="relative h-24 w-24 rounded-full overflow-hidden bg-indigo-100 border-2 border-indigo-200 flex items-center justify-center text-indigo-600 text-3xl font-bold flex-shrink-0 shadow-sm">
        
        <div wire:loading.flex wire:target="photo" class="absolute inset-0 bg-white/80 items-center justify-center z-20">
            <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        @if ($photo)
            <img src="{{ $photo->temporaryUrl() }}" class="h-full w-full object-cover">
        @elseif ($user->avatar_path)
            <img src="{{ asset('storage/' . $user->avatar_path) }}" class="h-full w-full object-cover">
        @else
            {{ substr($user->name, 0, 1) }}
        @endif
    </div>

    <form wire:submit="save" class="flex flex-col items-center sm:items-start w-full">
        <input type="file" wire:model="photo" id="photo-upload-{{ $user->id }}" class="hidden" accept="image/*">
        
        @if($photo)
            <div class="flex gap-2 mt-2">
                <button type="submit" wire:loading.attr="disabled" wire:target="save" class="text-xs font-semibold bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700 transition shadow-sm disabled:opacity-50">Save</button>
                <button type="button" wire:click="$set('photo', null)" class="text-xs font-medium bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 transition">Cancel</button>
            </div>
        @else
            <div class="flex gap-2 mt-2">
                <label for="photo-upload-{{ $user->id }}" class="text-xs font-medium bg-white border border-gray-300 text-gray-700 px-3 py-1.5 rounded shadow-sm hover:bg-gray-50 cursor-pointer transition">
                    Change Photo
                </label>
                @if($user->avatar_path)
                    <button type="button" wire:click="delete" wire:confirm="Are you sure you want to remove this photo?" class="text-xs font-medium text-red-600 hover:text-red-800 px-2 py-1.5 transition">Remove</button>
                @endif
            </div>
        @endif

        @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        
        @if (session()->has('avatar_success'))
            <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-green-600 text-xs font-medium mt-2 transition-opacity">
                {{ session('avatar_success') }}
            </span>
        @endif
    </form>
</div>