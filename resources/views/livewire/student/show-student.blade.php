<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('students.index') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center gap-1 mb-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Directory
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Student Profile') }}
                </h2>
            </div>
            
            <a href="{{ route('students.edit', $student->id) }}" wire:navigate class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition">
                Edit Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <livewire:shared.avatar-manager :user="$student" />
                    
                    <div class="text-center sm:text-left flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $student->name }}</h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">System ID / Roll No: <span class="text-indigo-600">{{ $student->studentProfile->roll_number ?? 'N/A' }}</span></p>
                        
                        <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-3">
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                Class: {{ $student->class()?->name ?? 'Not Enrolled' }}
                            </span>
                            
                            @if($student->studentProfile?->status === 'active')
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Active Student
                                </span>
                            @elseif($student->studentProfile?->status === 'graduated')
                                <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-sm font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20">
                                    Alumni / Graduated
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-sm font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                    Struck Off
                                </span>
                            @endif

                            @if($student->pending_dues > 0)
                                <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-sm font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                    Pending Dues: Rs. {{ number_format($student->pending_dues) }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    Fees Cleared
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="col-span-1 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Academic Summary</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Current Class</dt>
                                <dd class="font-medium text-gray-900">{{ $student->class()?->name ?? 'N/A' }} {{ $student->class()?->description ? '('.$student->class()->description.')' : '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Admission Date</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile?->admission_date ? \Carbon\Carbon::parse($student->studentProfile->admission_date)->format('d M, Y') : 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Student Contact</h3>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="text-gray-500">System Email</dt>
                                <dd class="font-medium text-gray-900">{{ $student->email ?? 'Not provided' }}</dd>
                            </div>
                            <div class="pt-2">
                                <dt class="text-gray-500">Personal Phone</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->personal_phone ?? 'Not provided' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Personal Information</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">B-Form / CNIC</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->cnic ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Date of Birth</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile?->date_of_birth ? \Carbon\Carbon::parse($student->studentProfile->date_of_birth)->format('d M, Y') : 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Gender</dt>
                                <dd class="font-medium text-gray-900 capitalize">{{ $student->studentProfile->gender ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Blood Group</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->blood_group ?? 'Unknown' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Guardian Information</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Guardian Name</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->guardian_name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Guardian Phone</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->guardian_phone ?? 'N/A' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-500">Home Address</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $student->studentProfile->address ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </div>

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Financial Activity</h3>
                    <a href="{{ route('fees.collect') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                        Go to Cashier Desk &rarr;
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Billing Month</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voucher #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($student->feeVouchers as $voucher)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $voucher->billing_month }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $voucher->voucher_number }}
                                        <div class="text-xs text-gray-400 mt-0.5">Due: {{ $voucher->due_date->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        Rs. {{ number_format($voucher->amount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($voucher->status === 'paid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Paid on {{ $voucher->paid_at->format('M d') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Unpaid
                                            </span>
                                        @endif

                                        <a href="{{ route('fees.print', $voucher->id) }}" target="_blank" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-900 transition ml-2">
                                            Print
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">
                                        No fee vouchers generated for this student yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <livewire:shared.document-manager :model="$student->studentProfile" />
            
        </div>
    </div>
</div>