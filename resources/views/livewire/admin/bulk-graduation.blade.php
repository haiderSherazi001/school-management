<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('students.index') }}" wire:navigate class="p-2.5 bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-indigo-600 transition shadow-sm group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                </a>
                <div>
                    <nav class="flex mb-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('dashboard') }}" wire:navigate class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition">Dashboard</a></li>
                            <li class="text-gray-300 text-[10px]">/</li>
                            <li><a href="{{ route('students.index') }}" wire:navigate class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition">Students</a></li>
                        </ol>
                    </nav>
                    <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                        {{ __('Bulk Graduation & Archive') }}
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start">
                <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold text-emerald-800 flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>
        @endif

        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-red-500"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-end">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">1. Select Source Class</label>
                    <select wire:model.live="filter_class_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-red-50 focus:border-red-400 transition sm:text-sm font-bold text-gray-700">
                        <option value="">-- Choose a Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->name }} {{ $class->description ? '('.$class->description.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">2. Desired Archive Status</label>
                    <select wire:model="target_status" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-red-50 focus:border-red-400 transition sm:text-sm font-bold text-red-600">
                        <option value="graduated">Graduated / Alumni</option>
                        <option value="struck_off">Struck Off / Left School</option>
                    </select>
                    @error('target_status') <span class="text-red-500 text-[10px] font-black mt-1.5 block uppercase tracking-tighter">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button wire:click="updateStatus" wire:loading.attr="disabled" class="w-full inline-flex justify-center items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md shadow-red-100 transition uppercase tracking-widest text-xs">
                        <span wire:loading.remove wire:target="updateStatus">Update Status</span>
                        <span wire:loading wire:target="updateStatus" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Archiving...
                        </span>
                    </button>
                    @error('selectedStudents') <p class="text-red-500 text-[10px] font-black mt-2 text-center uppercase tracking-tighter">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
            x-data="{
                selected: @entangle('selectedStudents'), 
                get allIds() {
                    return Array.from(this.$root.querySelectorAll('.student-checkbox')).map(el => el.value);
                },
                get allChecked() {
                    return this.selected.length === this.allIds.length && this.allIds.length > 0;
                },
                toggleAll() {
                    if (this.allChecked) {
                        this.selected = [];
                    } else {
                        this.selected = this.allIds;
                    }
                }
            }"
        >
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-black text-gray-900">
                        @if($filter_class_id)
                            {{ count($this->eligibleStudents) }} Active Students Found
                        @else
                            Waiting for selection...
                        @endif
                    </span>
                    <span class="h-4 w-px bg-gray-200 mx-1"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest" :class="selected.length > 0 ? 'text-red-600' : 'text-gray-400'">
                        <span x-text="selected.length"></span> Students Flagged
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left w-10">
                                <input type="checkbox" :checked="allChecked" @click="toggleAll()" class="rounded-md border-gray-300 text-red-600 focus:ring-red-500 shadow-sm transition" {{ !$filter_class_id ? 'disabled' : '' }}>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Student Information</th>
                            <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Roll Identifier</th>
                            <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Current Status</th>
                        </tr>
                    </thead>
                    
                    <tbody class="bg-white divide-y divide-gray-100" wire:loading.class="opacity-50 pointer-events-none" wire:target="filter_class_id">
                        @forelse($this->eligibleStudents as $student)
                            <tr class="hover:bg-red-50/30 transition group" wire:key="grad-student-{{ $student->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" x-model="selected" value="{{ $student->id }}" class="student-checkbox rounded-md border-gray-300 text-red-600 focus:ring-red-500 shadow-sm cursor-pointer transition">
                                </td> 
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-black text-gray-900 group-hover:text-red-700 transition">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-400 font-medium tracking-tight">{{ $student->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-black text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100 uppercase tracking-widest">{{ $student->studentProfile->roll_number ?? '---' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        Currently Active
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-4 rounded-full bg-gray-50 text-gray-300 mb-4">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <h3 class="text-base font-black text-gray-900">
                                            {{ $filter_class_id ? 'No students found in this class' : 'Roster is empty' }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1 max-w-xs mx-auto">
                                            {{ $filter_class_id ? 'All students in this class may already be archived.' : 'Select a class above to load the student roster for archiving.' }}
                                        </p>
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