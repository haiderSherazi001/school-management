<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('staff.index') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center gap-1 mb-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Directory
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Staff Profile') }}
                </h2>
            </div>
            <a href="{{ route('staff.edit', $staff->id) }}" wire:navigate class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition">
                Edit Staff Member
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <livewire:shared.avatar-manager :user="$staff" />
                    
                    <div class="text-center sm:text-left flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $staff->name }}</h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">System ID: <span class="text-indigo-600 font-semibold">{{ $staff->username }}</span></p>
                        
                        <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-3">
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ $staff->staffProfile->designation->title ?? 'Role Unassigned' }}
                            </span>
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                Active Employee
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="col-span-1 space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Employment Details</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Joining Date</dt>
                                <dd class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($staff->staffProfile->joining_date)->format('d M, Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Base Salary</dt>
                                <dd class="font-medium text-green-600">Rs. {{ number_format($staff->staffProfile->salary) }}</dd>
                            </div>
                            <div class="flex flex-col mt-2 pt-2 border-t">
                                <dt class="text-gray-500 mb-1">Qualification</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->staffProfile->qualification }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Contact Info</h3>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="text-gray-500">System Email</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->email ?? 'Not provided' }}</dd>
                            </div>
                            <div class="pt-2">
                                <dt class="text-gray-500">Phone Number</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->staffProfile->phone }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">HR & Personal Information</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                            <div>
                                <dt class="text-gray-500">CNIC Number</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->staffProfile->cnic }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Gender</dt>
                                <dd class="font-medium text-gray-900 capitalize">{{ $staff->staffProfile->gender }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-500">Permanent Address</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $staff->staffProfile->address }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mt-6">
                        <div class="p-4 bg-emerald-50 border-b border-emerald-100 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <h3 class="font-bold text-emerald-900">Financial Ledger & Salary History</h3>
                            </div>
                        </div>
                
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Billing Month</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Base Salary</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Adjustments</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Net Paid</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($staff->payslips as $slip)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($slip->billing_month)->format('F Y') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                Rs. {{ number_format($slip->base_salary) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($slip->bonuses > 0)
                                                    <span class="text-green-600 font-medium">+Rs. {{ number_format($slip->bonuses) }}</span><br>
                                                @endif
                                                @if($slip->deductions > 0)
                                                    <span class="text-red-600 font-medium">-Rs. {{ number_format($slip->deductions) }}</span>
                                                @endif
                                                @if($slip->bonuses == 0 && $slip->deductions == 0)
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-900">
                                                Rs. {{ number_format($slip->net_payable) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($slip->status === 'paid')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paid</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                                {{ $slip->paid_at ? $slip->paid_at->format('d M Y, h:i A') : '--' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                                No payroll records found for this staff member yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
            <livewire:shared.document-manager :model="$staff->staffProfile" />
        </div>
    </div>
</div>