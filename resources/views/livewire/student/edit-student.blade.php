<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student: ') }} <span class="text-indigo-600">{{ $name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-8">
                
                <form wire:submit="update">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        <div class="col-span-2 border-b border-gray-200 pb-2">
                            <h3 class="text-lg font-semibold text-gray-900">Academic Information</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Assign to Class</label>
                            <select wire:model="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select a Class --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} {{ $class->description ? '('.$class->description.')' : '' }}</option>
                                @endforeach
                            </select>
                            @error('class_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Roll Number</label>
                            <input type="text" wire:model="roll_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('roll_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Admission Date</label>
                            <input type="date" wire:model="admission_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('admission_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2 border-b border-gray-200 pb-2 mt-4">
                            <h3 class="text-lg font-semibold text-gray-900">Personal Details</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Student Full Name</label>
                            <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">System Login Email</label>
                            <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">B-Form / CNIC (13 digits)</label>
                            <input type="text" wire:model="cnic" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('cnic') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" wire:model="date_of_birth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Blood Group (Optional)</label>
                            <input type="text" wire:model="blood_group" placeholder="e.g., O+" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('blood_group') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2 border-b border-gray-200 pb-2 mt-4">
                            <h3 class="text-lg font-semibold text-gray-900">Parent / Guardian Details</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Guardian Name</label>
                            <input type="text" wire:model="guardian_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('guardian_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Guardian Phone</label>
                            <input type="text" wire:model="guardian_phone" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('guardian_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Guardian Email (Optional)</label>
                            <input type="email" wire:model="guardian_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('guardian_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Complete Home Address</label>
                            <textarea wire:model="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="mt-8 flex items-center justify-end gap-x-4 border-t border-gray-200 pt-5">
                        <a href="{{ route('students.index') }}" wire:navigate class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">Cancel</a>
                        
                        <button type="submit" wire:loading.attr="disabled" class="rounded-md bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                            <span wire:loading.remove wire:target="update" class="text-white">Update Student</span>
                            <span wire:loading wire:target="update" class="text-white">Processing...</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>