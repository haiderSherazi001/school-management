<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 tracking-tight leading-tight">
            {{ __('Staff Directory') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start">
                <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold text-emerald-800 flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            
            <div class="w-full lg:w-1/2 flex flex-col sm:flex-row gap-3">
                <div class="w-full sm:w-1/2 relative group">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search staff members..." 
                        class="w-full pl-9 pr-4 py-2.5 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-medium"
                    >
                </div>
    
                <div class="w-full sm:w-1/2">
                    <select wire:model.live="designationFilter" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700 py-2.5">
                        <option value="">All Designations</option>
                        @foreach($designations as $role)
                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full lg:w-auto justify-end">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <span>HR Operations</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50 divide-y divide-gray-100 overflow-hidden" style="display: none;">
                        <div class="py-1">
                            <a href="{{ route('payroll.generate') }}" wire:navigate class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-emerald-700 hover:bg-emerald-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Generate Payroll
                            </a>
                            <a href="{{ route('hr.attendance') }}" wire:navigate class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-indigo-700 hover:bg-indigo-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Mark Attendance
                            </a>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('staff.designations') }}" wire:navigate class="block px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-50 transition">Manage Roles</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('staff.create') }}" wire:navigate class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-5 rounded-xl shadow-md shadow-indigo-100 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Staff
                </a>
            </div>
        </div>

        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 overflow-x-auto no-scrollbar">
                @foreach(['active' => 'Active Staff', 'on_leave' => 'On Leave', 'resigned' => 'Resigned', 'terminated' => 'Terminated', 'all' => 'All Records'] as $key => $label)
                    <button wire:click="setFilter('{{ $key }}')" class="{{ $statusFilter === $key ? 'border-indigo-600 text-indigo-600 font-black' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-bold' }} whitespace-nowrap py-4 px-1 border-b-2 text-sm transition-all duration-200">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto" wire:loading.class="opacity-50 pointer-events-none" wire:target="setFilter, search, delete">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">#</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Name & Profile</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">System ID</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Role & Status</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Joining Date</th>
                            <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($staffMembers as $staff)
                            <tr class="hover:bg-indigo-50/30 transition group" wire:key="staff-{{ $staff->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-black text-gray-300">
                                    {{ $staffMembers->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-xs shadow-inner">
                                            {{ strtoupper(substr($staff->name, 0, 1)) }}{{ strtoupper(substr(strrchr($staff->name, " "), 1, 1)) ?: '' }}
                                        </div>
                                        <div>
                                            <a href="{{ route('staff.show', $staff->id) }}" wire:navigate class="text-sm font-black text-gray-900 group-hover:text-indigo-600 transition underline decoration-transparent group-hover:decoration-indigo-200">
                                                {{ $staff->name }}
                                            </a>
                                            <div class="text-xs text-gray-400 font-medium">{{ $staff->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-xs font-black text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">{{ $staff->username ?? '---' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-black text-gray-800">
                                        {{ $staff->staffProfile->designation->title ?? 'Unassigned' }}
                                    </div>
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                            'on_leave' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'resigned' => 'bg-gray-100 text-gray-600 border-gray-200',
                                            'terminated' => 'bg-red-50 text-red-700 border-red-100'
                                        ];
                                        $status = $staff->staffProfile->employment_status ?? 'active';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase border {{ $statusColors[$status] }} mt-1">
                                        {{ str_replace('_', ' ', $status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-700">
                                        {{ $staff->staffProfile ? \Carbon\Carbon::parse($staff->staffProfile->joining_date)->format('d M, Y') : 'N/A' }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-black uppercase">{{ $staff->staffProfile->phone ?? 'NO PHONE' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('staff.edit', $staff->id) }}" wire:navigate class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <button wire:click="delete({{ $staff->id }})" wire:confirm="Remove staff member? Profile will be deactivated." class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-4 rounded-full bg-gray-50 text-gray-300 mb-4">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <h3 class="text-base font-black text-gray-900">No staff records found</h3>
                                        <p class="text-sm text-gray-500 mt-1">Adjust filters or search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($staffMembers->hasPages())
                <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                    {{ $staffMembers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>