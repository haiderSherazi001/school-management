<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academics: Manage Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="mb-6 rounded-lg bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start transition-all duration-300">
                    <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Curriculum Manager</h3>
                    <p class="text-sm text-gray-500">Select a class below to view or modify its assigned subjects.</p>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3">
                    <select wire:model.live="class_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-semibold text-gray-700 bg-gray-50 py-2.5 transition">
                        <option value="">-- Select a Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} {{ $class->description ? '('. $class->description .')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($class_id)
                <div class="flex flex-col lg:flex-row gap-8 transition-all duration-500 ease-in-out">
                    
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                    @if($isEditing)
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Subject
                                    @else
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Add New Subject
                                    @endif
                                </h3>
                            </div>
                            
                            <div class="p-6">
                                <form wire:submit="saveSubject" class="space-y-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Subject Name</label>
                                        <input type="text" wire:model="name" placeholder="e.g. Mathematics" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition">
                                        @error('name') <span class="text-red-500 text-xs font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Default Total Marks</label>
                                        <input type="number" wire:model="total_marks" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition font-semibold text-gray-900">
                                        <p class="text-xs text-gray-500 mt-2 flex items-start gap-1">
                                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Teachers can override this limit during marks entry.
                                        </p>
                                        @error('total_marks') <span class="text-red-500 text-xs font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="pt-4 border-t border-gray-100 flex gap-3">
                                        @if($isEditing)
                                            <button type="button" wire:click="resetForm" class="flex-1 bg-white border border-gray-300 rounded-lg py-2.5 px-4 text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition shadow-sm">
                                                Cancel
                                            </button>
                                        @endif
                                        <button type="submit" wire:loading.attr="disabled" class="flex-1 bg-indigo-600 border border-transparent rounded-lg py-2.5 px-4 text-sm font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm flex justify-center items-center">
                                            <span wire:loading.remove wire:target="saveSubject">{{ $isEditing ? 'Save Changes' : 'Add Subject' }}</span>
                                            <span wire:loading wire:target="saveSubject">
                                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-2/3">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Subject Details</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Default Marks</th>
                                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($subjects as $subject)
                                            <tr class="hover:bg-indigo-50/30 transition group">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <div class="h-8 w-8 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                                            {{ substr($subject->name, 0, 1) }}
                                                        </div>
                                                        <span class="font-bold text-gray-900">{{ $subject->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                                        {{ $subject->total_marks }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="flex justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                                                        <button wire:click="editSubject({{ $subject->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Edit">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                        </button>
                                                        <button wire:click="deleteSubject({{ $subject->id }})" wire:confirm="Delete {{ $subject->name }} from this class? This will wipe associated exam marks!" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition" title="Remove">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-12 text-center">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <div class="h-12 w-12 text-gray-300 mb-3">
                                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                        </div>
                                                        <p class="text-base font-bold text-gray-900">No subjects assigned</p>
                                                        <p class="text-sm text-gray-500 mt-1">Use the form to add subjects to this curriculum.</p>
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
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center shadow-sm">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 mb-4">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Manage Curriculum</h3>
                    <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">Select a class from the dropdown above to view its current subjects, adjust standard marks, or add new curriculum items.</p>
                </div>
            @endif

        </div>
    </div>
</div>