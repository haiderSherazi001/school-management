<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Academic Classes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div wire:ignore x-data="{ show: true }" x-show="show" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 transition-all duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        </div>
                        <div class="ml-3 flex-1"><p class="text-sm font-medium text-green-800">{{ session('success') }}</p></div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="show = false" type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50 transition">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6">
                
                <div class="w-full lg:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Class Directory</h3>
                            <div class="w-1/2 relative">
                                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search classes..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10 text-sm">
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group/Description</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numeric</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($classes as $class)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $class->name }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $class->description ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $class->numeric_value }}</td>
                                            <td class="px-4 py-3 text-sm text-right font-medium space-x-3">
                                                <button wire:click="edit({{ $class->id }})" class="text-indigo-600 hover:text-indigo-900 transition">Edit</button>
                                                <button wire:click="delete({{ $class->id }})" wire:confirm="Are you sure you want to delete this class?" class="text-red-600 hover:text-red-900 transition">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No classes found matching your search.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $classes->links() }}</div>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6 sticky top-6">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">
                            {{ $isEditing ? 'Edit Class Details' : 'Add New Class' }}
                        </h3>

                        <form wire:submit="save">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Class Name</label>
                                    <input type="text" wire:model="name" placeholder="e.g., 10th" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Group / Description</label>
                                    <input type="text" wire:model="description" placeholder="e.g., Computer Science Group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Numeric Value (For Sorting)</label>
                                    <input type="number" wire:model="numeric_value" placeholder="e.g., 10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('numeric_value') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex items-center justify-end gap-x-3 pt-4 border-t">
                                @if($isEditing)
                                    <button type="button" wire:click="resetForm" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 mr-2">Cancel</button>
                                @endif
                                
                                <button type="submit" wire:loading.attr="disabled" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                                    <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Update Class' : 'Save Class' }}</span>
                                    <span wire:loading wire:target="save">Processing...</span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>