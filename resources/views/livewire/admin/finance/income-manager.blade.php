<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('General Income (Non-Student)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border-l-4 border-green-500 shadow-sm">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">
                            {{ $isEditing ? '✏️ Edit Income Record' : 'Log New Income' }}
                        </h3>
                        
                        <form wire:submit="save" class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Title / Source</label>
                                <input type="text" wire:model="title" placeholder="e.g. Canteen Rent - March" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Category</label>
                                <select wire:model="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Amount (Rs.)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rs.</span>
                                    </div>
                                    <input type="number" step="0.01" wire:model="amount" class="w-full rounded-md border-gray-300 pl-9 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                @error('amount') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Date Received</label>
                                <input type="date" wire:model="income_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('income_date') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Description (Optional)</label>
                                <textarea wire:model="description" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Any extra notes..."></textarea>
                            </div>

                            <div class="pt-4 flex items-center gap-3">
                                <button type="submit" wire:loading.attr="disabled" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition">
                                    <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Update Income' : 'Save Income' }}</span>
                                    <span wire:loading wire:target="save">Processing...</span>
                                </button>
                                
                                @if($isEditing)
                                    <button type="button" wire:click="resetFields" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-md hover:bg-gray-200 transition">Cancel</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Recent Income Records</h3>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search records..." class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-1">
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Amount</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($incomes as $income)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                {{ $income->income_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-gray-900">{{ $income->title }}</p>
                                                <p class="text-xs font-medium text-gray-500 mt-0.5">
                                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $income->category }}</span>
                                                </p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-emerald-600">
                                                Rs. {{ number_format($income->amount) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button wire:click="edit({{ $income->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                                <button wire:click="delete({{ $income->id }})" wire:confirm="Are you sure you want to delete this record?" class="text-red-600 hover:text-red-900">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                                No general income logged yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-200">
                            {{ $incomes->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>