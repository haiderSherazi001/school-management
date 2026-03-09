<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Dashboard
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Curriculum Management') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        @if (session()->has('success'))
            <div x-data="{ show: true }" 
                 x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })"
                 x-show="show" 
                 x-transition.opacity.duration.300ms 
                 class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start">
                <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-black text-emerald-800 flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-indigo-600"></div>
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-lg font-black text-gray-900 leading-tight">Class Curriculum Selection</h3>
                    <p class="text-xs font-medium text-gray-400 mt-1 uppercase tracking-widest">Step 1: Choose an active class registry</p>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3">
                    <select wire:model.live="class_id" class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 font-bold text-gray-700 bg-gray-50 py-3 transition">
                        <option value="">-- Select a Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} {{ $class->description ? '('. $class->description .')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @if($class_id)
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-sm border transition-all duration-300 overflow-hidden sticky top-8 {{ $isEditing ? 'border-indigo-300 ring-4 ring-indigo-50 shadow-lg' : 'border-gray-100' }}">
                        <div class="px-6 py-4 border-b border-gray-50 {{ $isEditing ? 'bg-indigo-50/30' : 'bg-gray-50/30' }}">
                            <h3 class="text-xs font-black uppercase tracking-widest {{ $isEditing ? 'text-indigo-700' : 'text-gray-900' }}">
                                {{ $isEditing ? 'Edit Subject Details' : 'Register New Subject' }}
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <form wire:submit="saveSubject" class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Subject Designation</label>
                                    <input type="text" wire:model="name" placeholder="e.g. Physics" class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-bold text-gray-900">
                                    @error('name') <span class="text-red-500 text-[10px] font-black mt-1.5 block uppercase">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Standard Total Marks</label>
                                    <input type="number" wire:model="total_marks" class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-black text-indigo-600">
                                    <p class="text-[10px] font-bold text-gray-400 mt-2 leading-relaxed italic">
                                        Note: This serves as the default limit for exam report cards.
                                    </p>
                                    @error('total_marks') <span class="text-red-500 text-[10px] font-black mt-1.5 block uppercase">{{ $message }}</span> @enderror
                                </div>

                                <div class="pt-4 border-t border-gray-50 flex gap-3">
                                    @if($isEditing)
                                        <button type="button" wire:click="resetForm" class="flex-1 bg-white border border-gray-300 rounded-xl py-2.5 px-4 text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition">
                                            Cancel
                                        </button>
                                    @endif
                                    <button type="submit" wire:loading.attr="disabled" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-4 rounded-xl shadow-md shadow-indigo-100 transition uppercase tracking-widest text-xs">
                                        <span wire:loading.remove wire:target="saveSubject">{{ $isEditing ? 'Update' : 'Add Subject' }}</span>
                                        <span wire:loading wire:target="saveSubject">
                                            <svg class="animate-spin h-4 w-4 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-5 bg-gray-50/50 border-b border-gray-100">
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Active Curriculum</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/30">
                                    <tr class="text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        <th class="px-8 py-4">Subject Information</th>
                                        <th class="px-8 py-4 text-center">Max Marks</th>
                                        <th class="px-8 py-4 text-right">Operations</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($subjects as $subject)
                                        <tr class="hover:bg-indigo-50/20 transition group">
                                            <td class="px-8 py-5 whitespace-nowrap">
                                                <div class="flex items-center gap-4">
                                                    <div class="h-10 w-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                                        {{ substr($subject->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <span class="text-sm font-black text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $subject->name }}</span>
                                                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter mt-0.5">Code: SUB-{{ $subject->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 whitespace-nowrap text-center">
                                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black bg-gray-100 text-gray-700 border border-gray-200">
                                                    {{ $subject->total_marks }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                                <div class="flex justify-end gap-3">
                                                    <button wire:click="editSubject({{ $subject->id }})" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition" title="Modify Curriculum">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    </button>
                                                    <button wire:click="deleteSubject({{ $subject->id }})" wire:confirm="Remove {{ $subject->name }}? Marks will be lost!" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition" title="Delete Entry">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-8 py-20 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="p-4 rounded-full bg-gray-50 text-gray-300 mb-4">
                                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    </div>
                                                    <h3 class="text-base font-black text-gray-900">No curriculum items</h3>
                                                    <p class="text-sm text-gray-500 mt-1">Start by adding subjects for the selected class.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 p-20 text-center shadow-sm">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 mb-6 text-indigo-500 border border-indigo-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900">Configure Academic Subjects</h3>
                <p class="text-sm text-gray-500 mt-2 max-w-sm mx-auto">Please select a specific class from the dropdown above to load and manage its subject catalog.</p>
            </div>
        @endif

    </div>
</div>