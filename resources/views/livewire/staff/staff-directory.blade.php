<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Directory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div wire:ignore x-data="{ show: true }" x-show="show" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 transition-all duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="show = false" type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50 transition">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 px-4 sm:px-0 gap-4">
                
                <div class="w-full sm:w-1/3 relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search by name, CNIC, or designation..." 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10"
                    >
                </div>
                <div class="w:full sm:w-1/3">
                        <select wire:model.live="designationFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700">
                            <option value="">All Roles</option>
                            @foreach($designations as $role)
                                <option value="{{ $role->id }}">{{ $role->title }}</option>
                            @endforeach
                        </select>
                </div>
                
                <div class="flex gap-2 w-full sm:w-auto overflow-x-auto pb-2 sm:pb-0">
                    <a href="{{ route('staff.designations') }}" wire:navigate class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition duration-150 ease-in-out whitespace-nowrap">
                        Manage Designations
                    </a>
                    <a href="{{ route('staff.create') }}" wire:navigate class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition duration-150 ease-in-out whitespace-nowrap">
                        + Add New Staff
                    </a>
                </div>
            </div>

            <div class="mb-6 px-4 sm:px-0 border-b border-gray-200">
                <nav class="-mb-px flex space-x-6 sm:space-x-8 overflow-x-auto" aria-label="Tabs">
                    <button wire:click="setFilter('active')" class="{{ $statusFilter === 'active' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        Active Staff
                    </button>
                    
                    <button wire:click="setFilter('on_leave')" class="{{ $statusFilter === 'on_leave' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        On Leave
                    </button>
                    
                    <button wire:click="setFilter('resigned')" class="{{ $statusFilter === 'resigned' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        Resigned
                    </button>

                    <button wire:click="setFilter('terminated')" class="{{ $statusFilter === 'terminated' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                        Terminated
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name & Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role & Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span>Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @forelse ($staffMembers as $staff)
                                <tr class="hover:bg-gray-50 transition" wire:key="staff-{{ $staff->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $staffMembers->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('staff.show', $staff->id) }}" wire:navigate class="text-sm font-bold text-indigo-600 hover:text-indigo-900 hover:underline transition">
                                            {{ $staff->name }}
                                        </a>
                                        <div class="text-sm text-gray-500">{{ $staff->email }}</div>
                                        <div class="text-xs text-gray-400 mt-1">CNIC: {{ $staff->staffProfile->cnic ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <div class="text-xs text-gray-400 mt-1">ID: {{ $staff->username ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 mb-1">
                                            {{ $staff->staffProfile->designation->title ?? 'Unassigned' }}
                                        </span>
                                        @if($staff->staffProfile->designation?->department)
                                            <span class="text-xs text-gray-500 ml-1">({{ $staff->staffProfile->designation->department }})</span>
                                        @endif
                                        <br>
                                        @if($staff->staffProfile->employment_status === 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">Active</span>
                                        @elseif($staff->staffProfile->employment_status === 'on_leave')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">On Leave</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 capitalize mt-1">{{ str_replace('_', ' ', $staff->staffProfile->employment_status ?? '') }}</span>
                                        @endif
                                    </td> 
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $staff->staffProfile->phone ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $staff->staffProfile ? \Carbon\Carbon::parse($staff->staffProfile->joining_date)->format('d M, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                        <a href="{{ route('staff.edit', $staff->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 font-semibold transition">Edit</a>
                                        
                                        <button 
                                            wire:click="delete({{ $staff->id }})" 
                                            wire:confirm="Are you sure you want to remove this staff member? Their historical data will be saved, but their account will be deactivated." 
                                            class="text-red-600 hover:text-red-900 font-semibold transition">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 whitespace-nowrap text-center">
                                        <div class="text-gray-500 text-sm">No staff members found in this category.</div>
                                        <div class="text-gray-400 text-xs mt-1">Adjust your search or add a new staff member.</div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $staffMembers->links() }}
            </div>

        </div>
    </div>
</div>