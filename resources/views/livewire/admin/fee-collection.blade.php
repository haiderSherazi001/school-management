<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fee Collection Desk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">
                
                <div class="w-full md:w-1/3">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 sticky top-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Find Student</h3>
                        
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search name or roll number..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10 sm:text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        @if(strlen($search) >= 2)
                            <div class="mt-2 bg-white border border-gray-200 rounded-md shadow-lg overflow-hidden absolute w-full z-10">
                                @forelse($this->searchResults as $student)
                                    <button wire:click="selectStudent({{ $student->id }})" class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-0 transition">
                                        <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                        <div class="text-xs text-gray-500">Roll No: {{ $student->studentProfile->roll_number ?? 'N/A' }}</div>
                                    </button>
                                @empty
                                    <div class="px-4 py-3 text-sm text-gray-500 text-center">No students found.</div>
                                @endforelse
                            </div>
                        @endif
                        
                        <div class="mt-6 text-xs text-gray-500 border-t pt-4">
                            <p>Type at least 2 characters to search. You can search by the student's full name or their exact Roll Number.</p>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/3">
                    @if($this->studentLedger)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                            
                            <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $this->studentLedger->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Roll Number: <span class="font-medium text-gray-900">{{ $this->studentLedger->studentProfile->roll_number ?? 'N/A' }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $this->studentLedger->studentProfile->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($this->studentLedger->studentProfile->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-0">
                                <ul class="divide-y divide-gray-200">
                                    @forelse($this->studentLedger->feeVouchers as $voucher)
                                        <li class="p-6 hover:bg-gray-50 transition">
                                            <div class="flex items-center justify-between">
                                                
                                                <div>
                                                    <div class="flex items-center">
                                                        <h4 class="text-lg font-semibold text-gray-900">{{ $voucher->billing_month }}</h4>
                                                        @if($voucher->status === 'unpaid')
                                                            <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                                        @else
                                                            <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Paid on {{ $voucher->paid_at->format('M d, Y') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-1 text-sm text-gray-500">
                                                        Voucher: {{ $voucher->voucher_number }} &bull; Due: {{ $voucher->due_date->format('M d, Y') }}
                                                    </div>
                                                </div>

                                                <div class="text-right flex flex-col items-end">
                                                    <span class="text-xl font-bold text-gray-900 mb-2">Rs. {{ number_format($voucher->amount) }}</span>
                                                    
                                                    @if($voucher->status === 'unpaid')
                                                        <button wire:click="markAsPaid({{ $voucher->id }})" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                                                            <span wire:loading.remove wire:target="markAsPaid({{ $voucher->id }})">Collect Payment</span>
                                                            <span wire:loading wire:target="markAsPaid({{ $voucher->id }})">Processing...</span>
                                                        </button>
                                                    @else
                                                        <button wire:click="revertPayment({{ $voucher->id }})" class="text-xs text-gray-400 hover:text-red-600 underline transition">
                                                            Revert to Unpaid
                                                        </button>
                                                    @endif

                                                    <a href="{{ route('fees.print', $voucher->id) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition mt-2">
                                                        Print
                                                    </a> 
                                                </div>

                                            </div>
                                        </li>
                                    @empty
                                        <div class="p-12 text-center">
                                            <p class="text-gray-500">No fee records found for this student.</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center h-full flex flex-col items-center justify-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="text-sm font-medium text-gray-900">No Student Selected</h3>
                            <p class="mt-1 text-sm text-gray-500">Search for a student on the left to view their financial ledger.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>