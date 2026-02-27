<div x-data="{ 
        isEditing: false, 
        isDirty: false,
        showSuccess: false,
        message: ''
     }" 
     @settings-saved.window="
        showSuccess = true; 
        isEditing = false; 
        isDirty = false; 
        message = $event.detail.message;
        setTimeout(() => showSuccess = false, 3000);
        window.scrollTo({top: 0, behavior: 'smooth'});
     "
     @beforeunload.window="if(isDirty) $event.returnValue = 'You have unsaved changes!'"
     x-on:livewire:navigating.window="if(isDirty && !confirm('You have unsaved changes. Are you sure you want to leave?')) $event.preventDefault()"
     class="py-12">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <div x-show="showSuccess" x-transition.opacity.duration.300ms style="display: none;" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800" x-text="message"></p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow sm:rounded-lg overflow-hidden border transition-all duration-300" :class="isEditing ? 'border-indigo-300 ring-2 ring-indigo-50' : 'border-gray-200'">
            
            <form wire:submit="save" @change="isDirty = true; isEditing = true">
                
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                        
                        <button x-show="!isEditing" @click="isEditing = true" type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md transition">
                            ✏️ Edit Settings
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">School Name</label>
                            <input type="text" wire:model="school_name" :disabled="!isEditing" class="mt-1 block w-full rounded-md shadow-sm sm:text-sm transition-colors disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300">
                            @error('school_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Official Email</label>
                            <input type="email" wire:model="school_email" :disabled="!isEditing" class="mt-1 block w-full rounded-md shadow-sm sm:text-sm transition-colors disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300">
                            @error('school_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" wire:model="school_phone" :disabled="!isEditing" class="mt-1 block w-full rounded-md shadow-sm sm:text-sm transition-colors disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Campus Address</label>
                            <textarea wire:model="school_address" rows="3" :disabled="!isEditing" class="mt-1 block w-full rounded-md shadow-sm sm:text-sm transition-colors disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300"></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Academic Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Academic Session</label>
                            <select wire:model="current_session" :disabled="!isEditing" class="mt-1 block w-full rounded-md shadow-sm sm:text-sm transition-colors disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300">
                                @foreach($availableSessions as $sessionOption)
                                    <option value="{{ $sessionOption }}">{{ $sessionOption }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">This determines which students appear in active registers and fee vouchers.</p>
                            @error('current_session') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div x-show="isEditing" x-transition style="display: none;" class="px-6 py-4 bg-gray-50 flex justify-end gap-3 border-t border-gray-200">
                    
                    <button type="button" 
                            @click="$el.closest('form').reset(); isEditing = false; isDirty = false;" 
                            wire:click="cancel" 
                            class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        Discard Changes
                    </button>
                    
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        <span wire:loading.remove wire:target="save">Save Settings</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</div>