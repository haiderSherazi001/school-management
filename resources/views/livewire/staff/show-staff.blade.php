<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('staff.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Directory
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Staff Member Profile') }}
                </h2>
            </div>
            
            <a href="{{ route('staff.edit', $staff->id) }}" wire:navigate class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md shadow-indigo-100 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Record
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div>
                    <livewire:shared.avatar-manager :user="$staff" />
                </div>
                
                <div class="text-center sm:text-left flex-1">
                    <h1 class="text-3xl font-black text-gray-900 leading-tight">{{ $staff->name }}</h1>
                    <p class="text-sm font-medium text-gray-500 mt-1 uppercase tracking-widest">Employee ID: <span class="text-indigo-600 font-black">{{ $staff->username }}</span></p>
                    
                    <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-3">
                        <span class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1 text-xs font-black text-blue-700 border border-blue-100 uppercase tracking-wider">
                            {{ $staff->staffProfile->designation->title ?? 'Role Unassigned' }}
                        </span>
                        
                        <span class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700 border border-emerald-100 uppercase tracking-wider">
                            Active Employee
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="col-span-1 space-y-6">
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/30 border-b border-gray-50">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Employment Details</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-gray-400 uppercase text-[10px]">Joining Date</span>
                            <span class="font-black text-gray-900">{{ \Carbon\Carbon::parse($staff->staffProfile->joining_date)->format('d M, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-gray-400 uppercase text-[10px]">Salary</span>
                            <span class="font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Rs. {{ number_format($staff->staffProfile->salary) }}</span>
                        </div>
                        <div class="pt-2">
                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1">Qualification</p>
                            <p class="text-sm font-black text-gray-900">{{ $staff->staffProfile->qualification }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/30 border-b border-gray-50">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Contact Info</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div>
                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1">System Email</p>
                            <p class="font-black text-gray-900 break-all underline decoration-indigo-100 underline-offset-4">{{ $staff->email ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1">Phone Number</p>
                            <p class="font-black text-gray-900">{{ $staff->staffProfile->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 space-y-6">
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/30 border-b border-gray-50 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider">HR & Personal Information</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 text-sm">
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">CNIC Number</dt>
                            <dd class="font-black text-gray-900 tracking-widest">{{ $staff->staffProfile->cnic }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Gender</dt>
                            <dd class="font-black text-gray-900 capitalize">{{ $staff->staffProfile->gender }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Permanent Home Address</dt>
                            <dd class="font-medium text-gray-700 italic">"{{ $staff->staffProfile->address }}"</dd>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-emerald-50/50 border-b border-emerald-100 flex justify-between items-center">
                        <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Financial Ledger
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr class="text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="px-6 py-4">Billing Month</th>
                                    <th class="px-6 py-4">Adjustments</th>
                                    <th class="px-6 py-4">Net Paid</th>
                                    <th class="px-6 py-4 text-right">Payment Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($staff->payslips as $slip)
                                    <tr class="hover:bg-gray-50 transition text-sm">
                                        <td class="px-6 py-4 font-black text-gray-900">
                                            {{ \Carbon\Carbon::parse($slip->billing_month)->format('F Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($slip->bonuses > 0) <span class="text-emerald-600 font-bold">+{{ number_format($slip->bonuses) }}</span> @endif
                                            @if($slip->deductions > 0) <span class="text-red-500 font-bold">-{{ number_format($slip->deductions) }}</span> @endif
                                            @if($slip->bonuses == 0 && $slip->deductions == 0) <span class="text-gray-300">---</span> @endif
                                        </td>
                                        <td class="px-6 py-4 font-black text-gray-900">Rs. {{ number_format($slip->net_payable) }}</td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap">
                                            @if($slip->status === 'paid')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">Paid</span>
                                                <div class="text-[9px] font-bold text-gray-400 mt-0.5">{{ $slip->paid_at->format('d M') }}</div>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-amber-100 text-amber-800 uppercase">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">No payroll history found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden p-2">
             <livewire:shared.document-manager :model="$staff->staffProfile" />
        </div>
        
    </div>
</div>