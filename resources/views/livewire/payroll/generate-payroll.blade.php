<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payroll Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session()->has('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-md p-4 flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-md p-4 flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('info') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-md p-4 flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Monthly Payroll Run</h3>
                        <p class="text-sm text-gray-500">Generate drafted payslips for all active staff members. You can edit bonuses/deductions before finalizing.</p>
                    </div>
                    
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <input type="month" wire:model.live="billing_month" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium text-gray-700">
                        
                        <button 
                            wire:click="generate" 
                            wire:loading.attr="disabled"
                            wire:confirm="Are you sure you want to generate payslips for {{ \Carbon\Carbon::parse($billing_month)->format('F Y') }}?"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md shadow-sm transition whitespace-nowrap">
                            <span wire:loading.remove wire:target="generate">Generate Payslips</span>
                            <span wire:loading wire:target="generate">Generating...</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-4 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h3 class="font-bold text-gray-800">Payslips for {{ \Carbon\Carbon::parse($billing_month)->format('F Y') }}</h3>
                    
                    <div class="flex items-center gap-3">
                        @if($payslips->where('status', 'pending')->count() > 0)
                            <button 
                                wire:click="markAllAsPaid" 
                                wire:loading.attr="disabled"
                                wire:confirm="Are you sure you want to mark ALL pending payslips for this month as paid? This action is permanent."
                                class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm transition flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span wire:loading.remove wire:target="markAllAsPaid">Mark All Pending as Paid</span>
                                <span wire:loading wire:target="markAllAsPaid">Processing...</span>
                            </button>
                        @endif
                        
                        <span class="text-xs font-bold text-gray-600 bg-gray-200 px-2 py-1 rounded">{{ $payslips->count() }} Records</span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Salary</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Payable</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($payslips as $slip)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">{{ $slip->staff->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $slip->staff->staffProfile->designation->title ?? 'Unassigned' }} {{ $slip->staff->staffProfile->designation->department ? ('('.$slip->staff->staffProfile->designation->department.')') : 'Unassigned' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rs. {{ number_format($slip->base_salary) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        Rs. {{ number_format($slip->net_payable) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($slip->status === 'paid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paid</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                        @if($slip->status === 'pending')
                                            <button wire:click="editDraft({{ $slip->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold transition">Adjust Pay</button>
                                            
                                            <button 
                                                wire:click="markAsPaid({{ $slip->id }})" 
                                                wire:confirm="Are you sure you want to mark this payslip as PAID? This action is permanent."
                                                class="text-emerald-600 hover:text-emerald-900 font-semibold transition">
                                                Mark Paid
                                            </button>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed">Locked</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-gray-500 text-sm">No payslips generated for this month yet.</p>
                                        <p class="text-gray-400 text-xs mt-1">Click the Generate button above to draft them automatically.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @if($editingPayslipId)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                                    Adjust Payslip: {{ $staffName }}
                                </h3>
                                
                                <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-3 rounded border border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Base Salary</p>
                                        <p class="text-lg font-semibold text-gray-700">Rs. {{ number_format($edit_base_salary) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 uppercase font-bold">Net Payable</p>
                                        <p class="text-2xl font-black text-indigo-600">Rs. {{ number_format($edit_net_payable) }}</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Add Bonuses / Allowances (Rs.)</label>
                                        <input type="number" wire:model.live="edit_bonuses" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm text-green-700 font-bold">
                                        @error('edit_bonuses') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Deductions / Absences (Rs.)</label>
                                        <input type="number" wire:model.live="edit_deductions" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm text-red-700 font-bold">
                                        @error('edit_deductions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                        <button type="button" wire:click="saveDraft" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Save Adjustments
                        </button>
                        <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>