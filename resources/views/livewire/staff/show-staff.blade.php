<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Staff Profile') }}
            </h2>
            <a href="{{ route('staff.edit', $staff->id) }}" wire:navigate class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition">
                Edit Staff Member
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold flex-shrink-0">
                        {{ substr($staff->name, 0, 1) }}
                    </div>
                    
                    <div class="text-center sm:text-left flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $staff->name }}</h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">System ID: <span class="text-indigo-600 font-semibold">{{ $staff->username }}</span></p>
                        
                        <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-3">
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ $staff->staffProfile->designation }}
                            </span>
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                Active Employee
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="col-span-1 space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Employment Details</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Joining Date</dt>
                                <dd class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($staff->staffProfile->joining_date)->format('d M, Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Base Salary</dt>
                                <dd class="font-medium text-green-600">Rs. {{ number_format($staff->staffProfile->salary) }}</dd>
                            </div>
                            <div class="flex flex-col mt-2 pt-2 border-t">
                                <dt class="text-gray-500 mb-1">Qualification</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->staffProfile->qualification }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Contact Info</h3>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="text-gray-500">System Email</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->email ?? 'Not provided' }}</dd>
                            </div>
                            <div class="pt-2">
                                <dt class="text-gray-500">Phone Number</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->staffProfile->phone }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">HR & Personal Information</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                            <div>
                                <dt class="text-gray-500">CNIC Number</dt>
                                <dd class="font-medium text-gray-900">{{ $staff->staffProfile->cnic }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Gender</dt>
                                <dd class="font-medium text-gray-900 capitalize">{{ $staff->staffProfile->gender }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-500">Permanent Address</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $staff->staffProfile->address }}</dd>
                            </div>
                        </dl>
                    </div>

                </div>

            </div>
            <livewire:shared.document-manager :model="$staff->staffProfile" />
        </div>
    </div>
</div>