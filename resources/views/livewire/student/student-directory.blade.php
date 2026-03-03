<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Directory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div wire:ignore x-data="{ show: true }" x-show="show" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 transition-all duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="show = false" type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50 transition">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 px-4 sm:px-0 gap-4">
                            
                <div class="w-full md:w-1/3 relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search by name, roll no, or guardian..." 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10"
                    >
                </div>
                
                <div class="flex flex-wrap sm:flex-nowrap gap-3 w-full md:w-auto justify-end">
                    <a href="{{ route('students.bulk-graduate') }}" wire:navigate class="w-full sm:w-auto text-center bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition duration-150 ease-in-out whitespace-nowrap">
                        Bulk Graduation
                    </a>
                    
                    <a href="{{ route('students.create') }}" wire:navigate class="w-full sm:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition duration-150 ease-in-out whitespace-nowrap">
                        + Add New Student
                    </a>

                    <a href="{{ route('fees.generate') }}" wire:navigate class="w-full sm:w-auto text-center bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition duration-150 ease-in-out whitespace-nowrap">
                         Generate Fees
                    </a>

                    <a href="{{ route('fees.collect') }}" wire:navigate class="w-full sm:w-auto text-center bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition duration-150 ease-in-out whitespace-nowrap">
                         Collect Fees
                    </a>
                </div>

            </div>

            <div class="mb-6 px-4 sm:px-0 border-b border-gray-200">
                <nav class="-mb-px flex space-x-6 sm:space-x-8 overflow-x-auto" aria-label="Tabs">
                    <button wire:click="setFilter('active')" class="{{ $statusFilter === 'active' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        Active Students
                    </button>
                    
                    <button wire:click="setFilter('graduated')" class="{{ $statusFilter === 'graduated' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        Alumni / Graduated
                    </button>
                    
                    <button wire:click="setFilter('struck_off')" class="{{ $statusFilter === 'struck_off' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        Struck Off
                    </button>
                    
                    <button wire:click="setFilter('all')" class="{{ $statusFilter === 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        All Records
                    </button>
                </nav>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto" wire:loading.class="opacity-50 pointer-events-none" wire:target="setFilter, search, delete">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Info</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Academic</th>
                                
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Financials</th>
                                
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guardian</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @forelse ($students as $student)
                                <tr class="hover:bg-gray-50 transition" wire:key="student-row-{{ $student->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $students->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('students.show', $student->id) }}" wire:navigate class="text-sm font-bold text-indigo-600 hover:text-indigo-900 hover:underline transition">
                                            {{ $student->name }}
                                        </a>
                                        <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-semibold">
                                            {{ $student->currentClass()?->name ?? 'Unassigned' }} 
                                            @if($student->currentClass()?->description)
                                                <span class="text-xs text-gray-500 font-normal">({{ $student->currentClass()->description }})</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">Roll: {{ $student->studentProfile->roll_number ?? 'N/A' }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->studentProfile?->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @elseif($student->studentProfile?->status === 'graduated')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Alumni
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Struck Off
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->pending_dues > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                                Dues: Rs. {{ number_format($student->pending_dues) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Cleared
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $student->studentProfile->guardian_name ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $student->studentProfile->guardian_phone ?? 'N/A' }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $student->studentProfile ? \Carbon\Carbon::parse($student->studentProfile->admission_date)->format('d M, Y') : 'N/A' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                        <a href="{{ route('students.edit', $student->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 font-semibold transition">Edit</a>
                                        
                                        <button 
                                            wire:click="delete({{ $student->id }})" 
                                            wire:confirm="Are you sure you want to remove this student? Their academic history will be saved, but their profile will be deactivated." 
                                            class="text-red-600 hover:text-red-900 font-semibold transition">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 whitespace-nowrap text-center">
                                        <div class="text-gray-500 text-sm">No students found matching this filter.</div>
                                        <div class="text-gray-400 text-xs mt-1">Adjust your search or click a different tab.</div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $students->links() }}
            </div>

        </div>
    </div>
</div>