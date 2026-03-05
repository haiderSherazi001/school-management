<div>
    <x-slot name="header">
        <div>
            <a href="{{ route('dashboard') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center gap-1 mb-1 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                Back to Dashboard
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student Promotion') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between items-end gap-4">
                
                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Previous Class:</label>
                    <select wire:model.live="filter_previous_class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Show All Unassigned Students</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->name }} {{ $class->description ? '('.$class->description.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Promote Selected To:</label>
                    <select wire:model="target_class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Select Destination Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->name }} {{ $class->description ? '('.$class->description.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('target_class_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="w-full md:w-auto">
                    <button wire:click="enrollSelected" wire:loading.attr="disabled" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition">
                        <span wire:loading.remove wire:target="enrollSelected">Enroll Selected</span>
                        <span wire:loading wire:target="enrollSelected">Processing...</span>
                    </button>
                    @error('selectedStudents') <p class="text-red-500 text-xs mt-1 text-right">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200"
                x-data="{
                    selected: @entangle('selectedStudents'), 
                    allIds: [{{ $this->eligibleStudents->pluck('id')->map(fn($id) => "'$id'")->implode(',') }}],
                    get allChecked() {
                        return this.selected.length === this.allIds.length && this.allIds.length > 0;
                    },
                    toggleAll() {
                        if (this.allChecked) {
                            this.selected = [];
                        } else {
                            this.selected = [...this.allIds];
                        }
                    }
                }"
            >
                <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">
                        Found {{ count($this->eligibleStudents) }} students
                    </span>
                    <span class="text-xs font-bold" :class="selected.length > 0 ? 'text-indigo-600' : 'text-gray-500'">
                        <span x-text="selected.length"></span> selected
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 relative">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" :checked="allChecked" @click="toggleAll()" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">Last Known Class</th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200" wire:loading.class="opacity-50 pointer-events-none" wire:target="filter_previous_class_id">
                            @forelse($this->eligibleStudents as $student)
                                <tr class="hover:bg-gray-50 transition" wire:key="student-{{ $student->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" x-model="selected" value="{{ $student->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $student->studentProfile->roll_number ?? 'N/A' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-yellow-800 bg-yellow-50">
                                        @php $lastClass = $student->enrollments->first()?->class; @endphp
                                        
                                        @if($lastClass)
                                            {{ $lastClass->name }} 
                                            @if($lastClass->description)
                                                <span class="text-xs text-yellow-600 font-normal">({{ $lastClass->description }})</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400 font-normal">Never Enrolled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 text-sm">
                                        No unassigned students match this filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>