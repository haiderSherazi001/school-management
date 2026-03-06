<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Generate Fee Vouchers') }}
            </h2>
            <a href="{{ route('fees.collect') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Collect Fees') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 flex items-start">
                    <svg class="h-5 w-5 text-green-400 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200 flex items-start">
                    <svg class="h-5 w-5 text-red-400 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-md text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Monthly Itemized Generator</h3>
                        <p class="text-sm text-gray-500">Generate structured invoices for students based on their class fee schedule.</p>
                    </div>
                </div>

                <div class="p-6">
                    <form wire:submit="generateVouchers">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Billing Month</label>
                                <input type="month" wire:model="billing_month" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="text-[11px] text-gray-500 mt-1 uppercase font-semibold">Label written on voucher</p>
                                @error('billing_month') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Payment Due Date</label>
                                <input type="date" wire:model="due_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="text-[11px] text-gray-500 mt-1 uppercase font-semibold">Final date before late fine</p>
                                @error('due_date') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Target Classes</label>
                            <select wire:model="target_class_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Generate for ALL Classes (Entire School)</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">
                                        {{ $class->name }} {{ $class->description ? '('.$class->description.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div x-data="{ items: @entangle('customItems') }" class="mb-8 bg-gray-50 rounded-lg p-5 border border-gray-200">
                            <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Extra Charges / Custom Line Items</h4>
                                    <p class="text-xs text-gray-500">Applied to EVERY student in the selected target class above.</p>
                                </div>
                                <button type="button" @click="items.push({ title: '', amount: '' })" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                    + Add Item
                                </button>
                            </div>

                            <div x-show="items.length > 0" x-cloak class="space-y-3">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex gap-3 items-start animate-fade-in-up">
                                        <div class="flex-1">
                                            <input type="text" x-model="item.title" placeholder="Charge Name (e.g. Sports Gala)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error("customItems.*.title") <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-32">
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                                    <span class="text-gray-500 sm:text-sm text-xs">Rs.</span>
                                                </div>
                                                <input type="number" x-model="item.amount" placeholder="500" class="w-full rounded-md border-gray-300 pl-7 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                            @error("customItems.*.amount") <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <button type="button" @click="items.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 bg-white border border-gray-200 rounded-md shadow-sm hover:bg-red-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            
                            <div x-show="items.length === 0" x-cloak class="text-center py-4 bg-white border border-dashed border-gray-300 rounded-md">
                                <p class="text-sm font-medium text-gray-500">No extra charges added.</p>
                                <p class="text-xs text-gray-400">Only standard tuition fees will be generated.</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 -mx-6 -mb-6 p-4 sm:px-6 border-t border-gray-200 flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="h-5 w-5 text-emerald-500 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Duplicate protection active
                            </div>
                            
                            <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <span wire:loading.remove wire:target="generateVouchers">Generate Itemized Vouchers</span>
                                <span wire:loading wire:target="generateVouchers">Processing...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>