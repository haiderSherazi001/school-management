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
     class="py-12 bg-gray-50/50 min-h-screen">

    <x-slot name="header">
        <div>
            <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                Back to Dashboard
            </a>
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Global Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <div x-show="showSuccess" x-transition.opacity.duration.300ms style="display: none;" class="rounded-xl bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start">
            <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
            <p class="text-sm font-bold text-emerald-800" x-text="message"></p>
        </div>

        <div class="bg-white shadow-sm sm:rounded-2xl overflow-hidden border transition-all duration-300" :class="isEditing ? 'border-indigo-300 ring-4 ring-indigo-50' : 'border-gray-100'">
            
            <form wire:submit="save" @change="isDirty = true; isEditing = true" class="divide-y divide-gray-100">
                
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-black text-gray-900">General Information</h3>
                            <p class="text-sm text-gray-500 mt-1">Update your school's official contact details and branding.</p>
                        </div>
                        
                        <button x-show="!isEditing" @click="isEditing = true" type="button" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-lg transition border border-indigo-100 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Details
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">School Name</label>
                            <input type="text" wire:model="school_name" :disabled="!isEditing" class="block w-full rounded-lg shadow-sm sm:text-sm transition-colors disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300 font-medium text-gray-900">
                            @error('school_name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Official Email</label>
                            <input type="email" wire:model="school_email" :disabled="!isEditing" class="block w-full rounded-lg shadow-sm sm:text-sm transition-colors disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300 font-medium text-gray-900">
                            @error('school_email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Phone Number</label>
                            <input type="text" wire:model="school_phone" :disabled="!isEditing" class="block w-full rounded-lg shadow-sm sm:text-sm transition-colors disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300 font-medium text-gray-900">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Campus Address</label>
                            <textarea wire:model="school_address" rows="3" :disabled="!isEditing" class="block w-full rounded-lg shadow-sm sm:text-sm transition-colors disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300 font-medium text-gray-900"></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 bg-gray-50/50">
                    <div class="mb-6">
                        <h3 class="text-lg font-black text-gray-900">Academic Configuration</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage global rules for the current running school year.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                            <label class="block text-xs font-bold text-indigo-700 uppercase tracking-wider mb-2">Current Academic Session</label>
                            <select wire:model="current_session" :disabled="!isEditing" class="block w-full rounded-lg shadow-sm sm:text-sm transition-colors disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 border-gray-300 font-bold text-gray-900">
                                @foreach($availableSessions as $sessionOption)
                                    <option value="{{ $sessionOption }}">{{ $sessionOption }}</option>
                                @endforeach
                            </select>
                            <p class="mt-3 text-xs font-medium text-gray-500 leading-relaxed">
                                <span class="text-amber-600 font-bold">⚠️ Warning:</span> Changing this session will immediately update which students appear in active registers, fee vouchers, and exam entry screens.
                            </p>
                            @error('current_session') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div x-show="isEditing" x-transition style="display: none;" class="px-6 py-5 bg-white flex flex-col-reverse sm:flex-row justify-end gap-3 border-t border-gray-100">
                    <button type="button" 
                            @click="$el.closest('form').reset(); isEditing = false; isDirty = false;" 
                            wire:click="cancel" 
                            class="rounded-lg border border-gray-300 bg-white py-2.5 px-6 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors w-full sm:w-auto">
                        Discard Changes
                    </button>
                    
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center items-center rounded-lg border border-transparent bg-indigo-600 py-2.5 px-8 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors w-full sm:w-auto">
                        <span wire:loading.remove wire:target="save">Save Settings</span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <div>
            <div class="mb-4">
                <h3 class="text-lg font-black text-gray-900">System Modules</h3>
                <p class="text-sm text-gray-500 mt-1">Manage master data and configurations for specific parts of the application.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('staff.designations') }}" wire:navigate class="group block p-6 border border-gray-200 rounded-2xl bg-white hover:-translate-y-1 hover:border-blue-300 hover:ring-2 hover:ring-blue-50 transition-all duration-300 shadow-sm hover:shadow-md">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h4 class="text-base font-black text-gray-900 group-hover:text-blue-700 transition-colors">HR Designations</h4>
                    <p class="text-sm font-medium text-gray-500 mt-2 line-clamp-2">Define job roles, departments, and active statuses for staff.</p>
                </a>

                <a href="{{ route('classes.index') }}" wire:navigate class="group block p-6 border border-gray-200 rounded-2xl bg-white hover:-translate-y-1 hover:border-emerald-300 hover:ring-2 hover:ring-emerald-50 transition-all duration-300 shadow-sm hover:shadow-md">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-emerald-500 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h4 class="text-base font-black text-gray-900 group-hover:text-emerald-700 transition-colors">Academic Classes</h4>
                    <p class="text-sm font-medium text-gray-500 mt-2 line-clamp-2">Configure classes, sections, and classroom capacities.</p>
                </a>

                <a href="{{ route('fees.generate') }}" wire:navigate class="group block p-6 border border-gray-200 rounded-2xl bg-white hover:-translate-y-1 hover:border-amber-300 hover:ring-2 hover:ring-amber-50 transition-all duration-300 shadow-sm hover:shadow-md">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-amber-500 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h4 class="text-base font-black text-gray-900 group-hover:text-amber-700 transition-colors">Financial Hub</h4>
                    <p class="text-sm font-medium text-gray-500 mt-2 line-clamp-2">Manage fee structures and bulk generate invoices.</p>
                </a>

            </div>
        </div>

    </div>
</div>