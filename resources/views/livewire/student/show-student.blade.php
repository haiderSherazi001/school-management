<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('students.index') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center gap-1 mb-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Directory
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Student Profile') }}
                </h2>
            </div>
            
            <a href="{{ route('students.edit', $student->id) }}" wire:navigate class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm text-sm transition">
                Edit Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold flex-shrink-0">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                    
                    <div class="text-center sm:text-left flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $student->name }}</h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">System ID / Roll No: <span class="text-indigo-600">{{ $student->username }}</span></p>
                        
                        <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-3">
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                Class: {{ $student->studentProfile->class->name ?? 'Unassigned' }}
                            </span>
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                Active Status
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="col-span-1 space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Academic Summary</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Current Class</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->class->name ?? 'N/A' }} {{ $student->studentProfile?->class?->description ? '('.$student->studentProfile->class->description.')' : '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Admission Date</dt>
                                <dd class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($student->studentProfile->admission_date)->format('d M, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Student Contact</h3>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="text-gray-500">System Email</dt>
                                <dd class="font-medium text-gray-900">{{ $student->email ?? 'Not provided' }}</dd>
                            </div>
                            <div class="pt-2">
                                <dt class="text-gray-500">Personal Phone</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->personal_phone ?? 'Not provided' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Personal Information</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">B-Form / CNIC</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->cnic }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Date of Birth</dt>
                                <dd class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($student->studentProfile->date_of_birth)->format('d M, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Gender</dt>
                                <dd class="font-medium text-gray-900 capitalize">{{ $student->studentProfile->gender }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Blood Group</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->blood_group ?? 'Unknown' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Guardian Information</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Guardian Name</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->guardian_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Guardian Phone</dt>
                                <dd class="font-medium text-gray-900">{{ $student->studentProfile->guardian_phone }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-500">Home Address</dt>
                                <dd class="font-medium text-gray-900 mt-1">{{ $student->studentProfile->address }}</dd>
                            </div>
                        </dl>
                    </div>

                </div>

            </div>
            <livewire:shared.document-manager :model="$student->studentProfile" />
        </div>
    </div>
</div>