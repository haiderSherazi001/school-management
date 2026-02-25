<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Staff Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                
                <form wire:submit="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="col-span-2 border-b pb-2 mb-2 flex justify-between items-end">
                            <h3 class="text-lg font-medium text-gray-900">Account Details</h3>
                            <span class="text-xs text-indigo-600 font-medium bg-indigo-50 px-2 py-1 rounded">Staff ID & Login Auto-Generated</span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Email (Optional)</label>
                            <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2 border-b pb-2 mb-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-900">HR & Personal Details</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">CNIC (without dashes)</label>
                            <input 
                                type="text" 
                                wire:model="cnic" 
                                maxlength="13" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error('cnic') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                         </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" wire:model="phone" placeholder="03XXXXXXXXX" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            maxlength="11" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                            >
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Designation (e.g., Mathematics Teacher)</label>
                            <input type="text" wire:model="designation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Qualification</label>
                            <input type="text" wire:model="qualification" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('qualification') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Base Salary (PKR)</label>
                            <input type="text" wire:model="salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Joining Date</label>
                            <input type="date" wire:model="joining_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('joining_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <select wire:model="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Full Address</label>
                            <textarea wire:model="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-4 border-t pt-4">
                        <a href="{{ route('staff.index') }}" wire:navigate class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">Cancel</a>
                        
                        <button type="submit" wire:loading.attr="disabled" class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <span wire:loading.remove wire:target="save" class="text-sm font-semibold leading-6 text-white">Save Staff Member</span>
                            <span wire:loading wire:target="save" class="text-sm font-semibold leading-6 text-white">Saving...</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>