<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Fee Collection Desk') }}
            </h2>
            <a href="{{ route('fees.generate') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Generate Fees') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6 items-start">
                
                <div class="w-full md:w-1/3 space-y-6 sticky top-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Find Student</h3>
                        
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search name or roll number..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10 sm:text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>

                        @if(strlen($search) >= 2)
                            <div class="mt-2 bg-white border border-gray-200 rounded-md shadow-lg overflow-hidden absolute w-[calc(100%-3rem)] z-20">
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
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-4 bg-orange-50 border-b border-orange-100 flex items-center justify-between">
                            <h3 class="font-bold text-orange-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pending Payments
                            </h3>
                            <span class="text-xs font-bold bg-orange-200 text-orange-800 px-2 py-0.5 rounded-full">{{ $this->defaulters->count() }}</span>
                        </div>
                        
                        <div class="max-h-[400px] overflow-y-auto p-2">
                            <ul class="divide-y divide-gray-100">
                                @forelse($this->defaulters as $defaulter)
                                    <li>
                                        <button wire:click="selectStudent({{ $defaulter->id }})" class="w-full text-left p-3 hover:bg-orange-50/50 rounded-md transition flex justify-between items-center group">
                                            <div>
                                                <p class="text-sm font-bold text-gray-900 group-hover:text-indigo-700 transition">{{ $defaulter->name }}</p>
                                                <p class="text-xs font-medium text-gray-500">{{ $defaulter->studentProfile->roll_number ?? 'N/A' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-black text-orange-600">Rs. {{ number_format($defaulter->total_due) }}</p>
                                                <p class="text-[10px] uppercase font-bold text-gray-400 group-hover:text-indigo-600 transition mt-0.5">View Ledger &rarr;</p>
                                            </div>
                                        </button>
                                    </li>
                                @empty
                                    <div class="p-6 text-center">
                                        <svg class="mx-auto h-8 w-8 text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-sm text-gray-500">All students are cleared!</p>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="w-full md:w-2/3">
                    @if($this->studentLedger)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                            <div class="p-6 border-b border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $this->studentLedger->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Roll Number: <span class="font-medium text-gray-900">{{ $this->studentLedger->studentProfile->roll_number ?? 'N/A' }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right flex items-center gap-3">
                                        <button wire:click="toggleInstantBillForm" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 border border-indigo-200 rounded-md text-xs font-bold text-indigo-700 shadow-sm hover:bg-indigo-100 transition">
                                            + Instant Bill
                                        </button>

                                        <button wire:click="$set('selectedStudentId', null)" class="text-xs text-gray-500 hover:text-gray-800 underline ml-2">Close</button>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $this->studentLedger->studentProfile->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($this->studentLedger->studentProfile->status) }}
                                        </span>
                                    </div>
                                </div>

                                @if($showInstantBillForm)
                                    <div class="mt-4 bg-white border border-indigo-200 rounded-md p-4 shadow-sm animate-fade-in-up">
                                        <h5 class="text-xs font-bold text-indigo-800 uppercase tracking-wider mb-3">Generate Instant Ad-Hoc Bill</h5>
                                        
                                        <form wire:submit="createInstantBill" class="flex flex-col sm:flex-row gap-3 items-start">
                                            <div class="flex-1 w-full">
                                                <input type="text" wire:model="instantBillTitle" placeholder="Charge Reason (e.g. ID Card Replacement)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @error('instantBillTitle') <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="w-full sm:w-32">
                                                <input type="number" wire:model="instantBillAmount" placeholder="Amount (Rs.)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @error('instantBillAmount') <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="flex gap-2 w-full sm:w-auto mt-1 sm:mt-0">
                                                <button type="button" wire:click="toggleInstantBillForm" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm font-bold text-gray-700 hover:bg-gray-200 transition shadow-sm flex-1 sm:flex-none">Cancel</button>
                                                <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 bg-indigo-600 rounded-md text-sm font-bold text-white hover:bg-indigo-700 transition shadow-sm flex-1 sm:flex-none">
                                                    <span wire:loading.remove wire:target="createInstantBill">Create Bill</span>
                                                    <span wire:loading wire:target="createInstantBill">Processing...</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <div class="p-0">
                                <ul class="divide-y divide-gray-200">
                                    @forelse($this->studentLedger->feeVouchers as $voucher)
                                        <li x-data="{ showItems: false }" class="p-6 hover:bg-gray-50 transition relative">
                                            
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <div class="flex items-center">
                                                        <h4 class="text-lg font-semibold text-gray-900">{{ $voucher->billing_month }}</h4>
                                                        @if($voucher->status === 'unpaid')
                                                            <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Pending</span>
                                                        @else
                                                            <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Paid on {{ $voucher->paid_at->format('M d, Y') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-1 text-sm font-medium text-gray-500">
                                                        Voucher: {{ $voucher->voucher_number }} &bull; Due: {{ $voucher->due_date->format('M d, Y') }}
                                                    </div>

                                                    <div class="mt-3 flex gap-4">
                                                        @if($voucher->items->count() > 0)
                                                            <button @click="showItems = !showItems" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                                                <span x-text="showItems ? 'Hide Breakdown' : 'View Breakdown ({{ $voucher->items->count() }} items)'"></span>
                                                                <svg class="w-4 h-4 transform transition-transform" :class="showItems ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                            </button>
                                                        @endif

                                                        @if($voucher->status === 'unpaid' && $activeVoucherId !== $voucher->id)
                                                            <button wire:click="openAddItemForm({{ $voucher->id }})" class="text-xs font-bold text-orange-600 hover:text-orange-800 flex items-center gap-1">
                                                                + Add Extra Charge
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="text-right flex flex-col items-end">
                                                    <span class="text-2xl font-black text-gray-900 mb-2">Rs. {{ number_format($voucher->amount) }}</span>
                                                    
                                                    @if($voucher->status === 'unpaid')
                                                        <button wire:click="markAsPaid({{ $voucher->id }})" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                                                            <span wire:loading.remove wire:target="markAsPaid({{ $voucher->id }})">Collect Payment</span>
                                                            <span wire:loading wire:target="markAsPaid({{ $voucher->id }})">Processing...</span>
                                                        </button>
                                                    @else
                                                        <button wire:click="revertPayment({{ $voucher->id }})" class="text-xs font-medium text-gray-400 hover:text-red-600 underline transition">
                                                            Revert to Unpaid
                                                        </button>
                                                    @endif

                                                    <a href="{{ route('fees.print', $voucher->id) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition mt-2">
                                                        Print Receipt
                                                    </a> 
                                                </div>
                                            </div>

                                            <div x-show="showItems" x-collapse class="mt-4 bg-white border border-gray-200 rounded-md p-4 shadow-inner">
                                                <table class="w-full text-sm">
                                                    <tbody>
                                                        @foreach($voucher->items as $item)
                                                            <tr class="border-b border-gray-100 last:border-0 group">
                                                                <td class="py-2 text-gray-600 w-full">{{ $item->title }}</td>
                                                                <td class="py-2 text-right font-bold text-gray-900 whitespace-nowrap">Rs. {{ number_format($item->amount) }}</td>
                                                                <td class="py-2 pl-3 text-right w-8">
                                                                    @if($voucher->status === 'unpaid')
                                                                        <button wire:click="removeCustomItem({{ $item->id }}, {{ $voucher->id }})" 
                                                                                wire:confirm="Are you sure you want to remove '{{ $item->title }}' from this bill?"
                                                                                class="text-gray-300 hover:text-red-500 transition" title="Remove Item">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if($activeVoucherId === $voucher->id)
                                                <div class="mt-4 bg-orange-50 border border-orange-200 rounded-md p-4 relative">
                                                    <h5 class="text-xs font-bold text-orange-800 uppercase tracking-wider mb-3">Add Custom Charge to this Bill</h5>
                                                    
                                                    <form wire:submit="saveCustomItem" class="flex flex-col sm:flex-row gap-3 items-start">
                                                        <div class="flex-1 w-full">
                                                            <input type="text" wire:model="newItemTitle" placeholder="Reason (e.g. Late Fine)" class="w-full rounded-md border-orange-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                                            @error('newItemTitle') <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="w-full sm:w-32">
                                                            <input type="number" wire:model="newItemAmount" placeholder="Amount (Rs.)" class="w-full rounded-md border-orange-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                                            @error('newItemAmount') <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="flex gap-2 w-full sm:w-auto mt-1 sm:mt-0">
                                                            <button type="button" wire:click="closeAddItemForm" class="px-3 py-2 bg-white border border-orange-300 rounded-md text-sm font-bold text-orange-700 hover:bg-orange-100 transition shadow-sm flex-1 sm:flex-none">Cancel</button>
                                                            <button type="submit" wire:loading.attr="disabled" class="px-3 py-2 bg-orange-600 rounded-md text-sm font-bold text-white hover:bg-orange-700 transition shadow-sm flex-1 sm:flex-none">
                                                                <span wire:loading.remove wire:target="saveCustomItem">Add</span>
                                                                <span wire:loading wire:target="saveCustomItem">...</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif

                                        </li>
                                    @empty
                                        <div class="p-12 text-center">
                                            <p class="text-gray-500 font-medium">No fee records found for this student.</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center h-[500px] flex flex-col items-center justify-center">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900">No Student Selected</h3>
                            <p class="mt-2 text-sm font-medium text-gray-500 max-w-sm">Use the search bar or click a student from the pending payments list to view their financial ledger and collect money.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>