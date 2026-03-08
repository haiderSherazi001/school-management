<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Academic Classes') }}
                </h2>
                <p class="text-sm font-medium text-gray-500 mt-1">Manage sections, sorting, and academic groups.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div x-data="{ open: false }" class="relative flex-1 md:flex-none">
                    <button @click="open = !open" @click.away="open = false" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        <span>Curriculum Tools</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50 divide-y divide-gray-100 overflow-hidden" style="display: none;">
                        <div class="py-1">
                            <a href="{{ route('fees.structure') }}" wire:navigate class="block px-4 py-2 text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">Fee Structure</a>
                            <a href="{{ route('academics.subjects') }}" wire:navigate class="block px-4 py-2 text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">Manage Subjects</a>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('academics.marks') }}" wire:navigate class="block px-4 py-2 text-sm font-bold text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">Marks Entry</a>
                            <a href="{{ route('academics.exams') }}" wire:navigate class="block px-4 py-2 text-sm font-bold text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">Exams Setup</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if (session()->has('success'))
            <div wire:ignore x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms class="mb-8 rounded-xl bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start">
                <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold text-emerald-800 flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-2/3 space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Class Directory</h3>
                        <div class="w-full sm:w-1/2 relative group">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Filter classes..." class="w-full pl-9 pr-4 py-2 rounded-xl border-gray-200 bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-medium">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/30">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">#</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Class Identity</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Academic Group</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Sort Order</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($classes as $class)
                                    <tr class="transition-all {{ $isEditing && $classId === $class->id ? 'bg-indigo-50/50' : 'hover:bg-gray-50/50' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs font-black text-gray-300">{{ $classes->firstItem() + $loop->index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-black text-gray-900">{{ $class->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                            {{ $class->description ?? 'General' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-black">{{ $class->numeric_value }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold space-x-3">
                                            <button wire:click="edit({{ $class->id }})" class="text-indigo-600 hover:text-indigo-900 transition">Edit</button>
                                            <button wire:click="delete({{ $class->id }})" wire:confirm="Are you sure? This will affect enrollments!" class="text-red-400 hover:text-red-700 transition">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No classes configured</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($classes->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">{{ $classes->links() }}</div>
                    @endif
                </div>
            </div>

            <div class="w-full lg:w-1/3" id="class-form-container"
                 x-data="{ isEditing: @entangle('isEditing') }"
                 x-init="$watch('isEditing', val => { if(val) { setTimeout(() => { document.getElementById('class-form-container').scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }, 100); } })">
                
                <div class="bg-white rounded-2xl shadow-sm border transition-all duration-300 sticky top-6 overflow-hidden {{ $isEditing ? 'border-indigo-300 ring-4 ring-indigo-50 shadow-lg' : 'border-gray-100' }}">
                    <div class="px-6 py-4 border-b border-gray-50 {{ $isEditing ? 'bg-indigo-50/30' : 'bg-gray-50/30' }}">
                        <h3 class="text-sm font-black uppercase tracking-widest {{ $isEditing ? 'text-indigo-700' : 'text-gray-900' }}">
                            {{ $isEditing ? 'Edit Class Details' : 'Register New Class' }}
                        </h3>
                    </div>

                    <form wire:submit="save" class="p-6 space-y-5">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Class Name</label>
                            <input type="text" wire:model="name" placeholder="e.g., Grade 10" class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-bold text-gray-900">
                            @error('name') <span class="text-red-500 text-[10px] font-black mt-1 block uppercase">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Academic Group / Description</label>
                            <input type="text" wire:model="description" placeholder="e.g., Science / Arts" class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-medium text-gray-700">
                            @error('description') <span class="text-red-500 text-[10px] font-black mt-1 block uppercase">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Numeric Sorting Value</label>
                            <input type="number" wire:model="numeric_value" placeholder="e.g., 10" class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-black text-indigo-600">
                            <p class="mt-2 text-[10px] font-medium text-gray-400 leading-tight">Used to sort classes correctly in dropdowns (e.g., 1 comes before 10).</p>
                            @error('numeric_value') <span class="text-red-500 text-[10px] font-black mt-1 block uppercase">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4 border-t border-gray-50 flex items-center justify-end gap-3">
                            @if($isEditing)
                                <button type="button" wire:click="resetForm" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition">Cancel</button>
                            @endif
                            
                            <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md shadow-indigo-100 transition text-xs uppercase tracking-widest">
                                <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Update' : 'Save Class' }}</span>
                                <span wire:loading wire:target="save">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>