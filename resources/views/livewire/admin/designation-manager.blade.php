<div>
    <x-slot name="header">
        <div>
            <a href="{{ route('staff.index') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center gap-1 mb-1 transition">
                &larr; Back to Staff
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Staff Designations') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6"
                 x-data="{ isEditing: @entangle('isEditing') }"
                 x-init="$watch('isEditing', val => {
                     if(val) {
                         setTimeout(() => {
                             document.getElementById('designation-form-container').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                         }, 100);
                     }
                 })">
                
                <div class="md:col-span-1" id="designation-form-container">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border transition-all duration-300 relative overflow-hidden"
                         :class="isEditing ? 'border-indigo-400 ring-4 ring-indigo-50 shadow-md' : 'border-gray-200'">
                        
                        <div x-show="isEditing" x-cloak class="absolute top-0 left-0 w-full h-1 bg-indigo-500 animate-pulse"></div>

                        <h3 class="text-lg font-medium mb-4 border-b pb-2 transition-colors duration-300" :class="isEditing ? 'text-indigo-700' : 'text-gray-900'">
                            <span x-text="isEditing ? '✏️ Update Designation' : 'Add Designation'"></span>
                        </h3>
                        
                        <form wire:submit="save">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" wire:model="title" placeholder="e.g. Senior Teacher" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Department (Optional)</label>
                                <input type="text" wire:model="department" placeholder="e.g. Academics, Administration" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="text-xs text-gray-500 mt-1">Helps group staff members together.</p>
                                @error('department') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Default Base Salary (Rs.)</label>
                                <input type="number" wire:model="default_salary" placeholder="e.g. 40000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="text-xs text-gray-500 mt-1">This will auto-fill when adding new staff, but can be overridden.</p>
                                @error('default_salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>  

                            <div class="mb-6 flex items-center">
                                <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                <label for="is_active" class="ml-2 text-sm text-gray-700">Active Designation</label>
                            </div>

                            <div class="flex items-center justify-end gap-x-3 pt-4 border-t">
                                <button type="button" x-show="isEditing" x-cloak wire:click="resetForm" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 mr-2">
                                    Cancel
                                </button>
                                
                                <button type="submit" wire:loading.attr="disabled" class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition w-full sm:w-auto">
                                    <span wire:loading.remove wire:target="save" x-text="isEditing ? 'Update Role' : 'Save Role'"></span>
                                    <span wire:loading wire:target="save">Processing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-4 bg-gray-50 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">School Designations</span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Default Salary</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($designations as $designation)
                                        <tr class="transition-colors hover:bg-gray-50" :class="(isEditing && {{ $designation_id ?? 'null' }} == {{ $designation->id }}) ? 'bg-indigo-50/50 ring-1 ring-inset ring-indigo-200' : ''">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                {{ $designation->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $designation->department ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $designation->default_salary }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($designation->is_active)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" wire:click="edit({{ $designation->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold transition">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 text-sm">
                                                <p>No designations added yet.</p>
                                                <p class="text-xs text-gray-400 mt-1">Add roles like 'Principal', 'Teacher', or 'Accountant' to get started.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>