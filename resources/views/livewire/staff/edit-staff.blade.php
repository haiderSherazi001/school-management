<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('staff.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Directory
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    Edit Staff Profile: <span class="text-indigo-600">{{ $name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <form wire:submit="update" class="space-y-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                    <h3 class="text-base font-black text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Account Credentials
                    </h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 border border-gray-200">
                        Login ID Locked
                    </span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Full Legal Name</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-black text-gray-900">
                        @error('name') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Official Email (Optional)</label>
                        <input type="email" wire:model="email" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-medium">
                        @error('email') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Staff ID / Username</label>
                        <div class="relative">
                            <input type="text" wire:model="username" disabled class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-400 font-bold sm:text-sm cursor-not-allowed">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="text-base font-black text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Employment & HR Information
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">CNIC Number</label>
                        <input type="text" wire:model="cnic" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold tracking-widest text-gray-700">
                        @error('cnic') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Phone Number</label>
                        <input type="text" wire:model="phone" maxlength="11" placeholder="03XXXXXXXXX" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold">
                        @error('phone') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Official Designation</label>
                        <select wire:model.live="designation_id" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700">
                            <option value="">-- Select a Role --</option>
                            @foreach($designations as $role)
                                <option value="{{ $role->id }}">{{ $role->title }} {{ $role->department ? '('.$role->department.')' : '' }}</option>
                            @endforeach
                        </select>
                        @error('designation_id') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Employment Status</label>
                        <select wire:model="employment_status" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold">
                            <option value="active">Active (Employed)</option>
                            <option value="on_leave">On Leave</option>
                            <option value="resigned">Resigned</option>
                            <option value="terminated">Terminated</option>
                        </select>
                        @error('employment_status') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Qualification</label>
                        <input type="text" wire:model="qualification" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm">
                        @error('qualification') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Base Salary (PKR)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 font-bold text-xs">Rs.</span>
                            <input type="text" wire:model="salary" class="w-full pl-10 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-black text-gray-900">
                        </div>
                        @error('salary') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Joining Date</label>
                        <input type="date" wire:model="joining_date" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-medium">
                        @error('joining_date') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Gender</label>
                        <select wire:model="gender" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="text-base font-black text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Residential Address
                    </h3>
                </div>
                <div class="p-6">
                    <textarea wire:model="address" rows="3" placeholder="Full residential address..." class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-medium"></textarea>
                    @error('address') <span class="text-red-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-x-4 pt-4 pb-12">
                <a href="{{ route('staff.index') }}" wire:navigate class="text-sm font-bold text-gray-500 hover:text-gray-800 transition">Cancel Changes</a>
                
                <button type="submit" wire:loading.attr="disabled" class="relative inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 px-10 rounded-xl shadow-lg shadow-indigo-100 transition-all duration-200 group">
                    <span wire:loading.remove wire:target="update" class="flex items-center gap-2">
                        Update Staff Record
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"></path></svg>
                    </span>
                    <span wire:loading wire:target="update" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>