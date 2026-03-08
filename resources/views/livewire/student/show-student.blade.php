<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('students.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Directory
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Student Profile') }}
                </h2>
            </div>
            
            <a href="{{ route('students.edit', $student->id) }}" wire:navigate class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md shadow-indigo-100 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Profile
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div>
                    <livewire:shared.avatar-manager :user="$student" />
                </div>
                
                <div class="text-center sm:text-left flex-1">
                    <h1 class="text-3xl font-black text-gray-900 leading-tight">{{ $student->name }}</h1>
                    <p class="text-sm font-medium text-gray-500 mt-1 uppercase tracking-widest">System ID: <span class="text-indigo-600 font-black">{{ $student->studentProfile->roll_number ?? 'N/A' }}</span></p>
                    
                    <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-3">
                        <span class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1 text-xs font-black text-blue-700 border border-blue-100">
                            {{ $student->class()?->name ?? 'Unassigned' }}
                        </span>
                        
                        @php
                            $statusColors = [
                                'active' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                'graduated' => 'bg-gray-50 text-gray-700 border-gray-200',
                                'struck_off' => 'bg-red-50 text-red-700 border-red-100'
                            ];
                            $statusLabel = ['active' => 'Active', 'graduated' => 'Alumni', 'struck_off' => 'Struck Off'];
                            $status = $student->studentProfile?->status ?? 'struck_off';
                        @endphp
                        <span class="inline-flex items-center rounded-lg px-3 py-1 text-xs font-black border uppercase tracking-wider {{ $statusColors[$status] }}">
                            {{ $statusLabel[$status] }}
                        </span>

                        @if($student->pending_dues > 0)
                            <span class="inline-flex items-center rounded-lg bg-orange-50 px-3 py-1 text-xs font-black text-orange-700 border border-orange-100">
                                Dues: Rs. {{ number_format($student->pending_dues) }}
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700 border border-emerald-100">
                                Fees Cleared
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="col-span-1 space-y-6">
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/30 border-b border-gray-50">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Academic Status</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-gray-400 uppercase text-[10px]">Current Class</span>
                            <span class="font-black text-gray-900">{{ $student->class()?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-gray-400 uppercase text-[10px]">Admission</span>
                            <span class="font-black text-gray-900">{{ $student->studentProfile?->admission_date ? \Carbon\Carbon::parse($student->studentProfile->admission_date)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/30 border-b border-gray-50">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Contact</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div>
                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1">System Email</p>
                            <p class="font-black text-gray-900 break-all underline decoration-indigo-100 underline-offset-4">{{ $student->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1">Guardian Phone</p>
                            <p class="font-black text-gray-900">{{ $student->studentProfile->guardian_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 space-y-6">
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/30 border-b border-gray-50 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider">Personal Information</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 text-sm">
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">B-Form / CNIC</dt>
                            <dd class="font-black text-gray-900 tracking-widest">{{ $student->studentProfile->cnic ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Date of Birth</dt>
                            <dd class="font-black text-gray-900">{{ $student->studentProfile?->date_of_birth ? \Carbon\Carbon::parse($student->studentProfile->date_of_birth)->format('d M, Y') : 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Gender</dt>
                            <dd class="font-black text-gray-900 capitalize">{{ $student->studentProfile->gender ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Blood Group</dt>
                            <dd class="font-black text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">{{ $student->studentProfile->blood_group ?? 'Unknown' }}</dd>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50/30 border-b border-gray-50 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider">Guardian Details</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 text-sm">
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Guardian Name</dt>
                            <dd class="font-black text-gray-900">{{ $student->studentProfile->guardian_name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Guardian Phone</dt>
                            <dd class="font-black text-gray-900">{{ $student->studentProfile->guardian_phone ?? 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-[10px] font-black text-gray-400 uppercase mb-1">Home Address</dt>
                            <dd class="font-medium text-gray-700 italic">"{{ $student->studentProfile->address ?? 'No address recorded.' }}"</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Recent Financial Activity
                </h3>
                <a href="{{ route('fees.collect') }}" wire:navigate class="text-[10px] font-black text-indigo-600 hover:text-indigo-900 uppercase tracking-widest">
                    Billing Desk &rarr;
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr class="text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="px-6 py-4">Billing Month</th>
                            <th class="px-6 py-4">Voucher Reference</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4 text-right">Payment Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($student->feeVouchers as $voucher)
                            <tr class="hover:bg-gray-50 transition text-sm">
                                <td class="px-6 py-4 font-black text-gray-900">{{ $voucher->billing_month }}</td>
                                <td class="px-6 py-4 text-gray-500 font-medium">
                                    {{ $voucher->voucher_number }}
                                    <div class="text-[9px] text-gray-400 uppercase font-black">Due: {{ $voucher->due_date->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 font-black text-gray-900">Rs. {{ number_format($voucher->amount) }}</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @if($voucher->status === 'paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 uppercase border border-emerald-100">Paid</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-red-50 text-red-700 uppercase border border-red-100">Unpaid</span>
                                    @endif
                                    <a href="{{ route('fees.print', $voucher->id) }}" target="_blank" class="ml-4 p-1.5 bg-gray-50 rounded-lg text-indigo-600 hover:bg-indigo-50 transition shadow-sm inline-flex items-center" title="Print Voucher">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">No billing records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
             <livewire:shared.document-manager :model="$student->studentProfile" />
        </div>
        
    </div>
</div>