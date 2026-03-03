<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Center') }}
            </h2>
            <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full border border-indigo-200 shadow-sm">
                Active Session: {{ $currentSession }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 text-gray-900 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gradient-to-r from-white to-indigo-50/30">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-sm font-medium text-gray-500 mt-1">Here is what is happening at <span class="text-indigo-600 font-bold">{{ $schoolName }}</span> today.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4 ring-4 ring-blue-50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Total Students</p>
                        <p class="text-3xl font-black text-gray-900">{{ $totalStudents }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4 ring-4 ring-green-50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Active Enrollments</p>
                        <p class="text-3xl font-black text-gray-900">{{ $enrolledStudents }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border {{ $unassignedStudents > 0 ? 'border-orange-300 bg-orange-50/50' : 'border-gray-200' }} flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 rounded-full {{ $unassignedStudents > 0 ? 'bg-orange-200 text-orange-700 ring-4 ring-orange-50' : 'bg-gray-100 text-gray-600' }} mr-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold {{ $unassignedStudents > 0 ? 'text-orange-800' : 'text-gray-500' }} mb-1 uppercase tracking-wider">Unassigned Students</p>
                        <p class="text-3xl font-black {{ $unassignedStudents > 0 ? 'text-orange-900' : 'text-gray-900' }}">{{ $unassignedStudents }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4 ring-4 ring-purple-50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Active Staff</p>
                        <p class="text-3xl font-black text-gray-900">{{ $activeStaff }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4 ring-4 ring-yellow-50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Total Alumni</p>
                        <p class="text-3xl font-black text-gray-900">{{ $totalAlumni }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 rounded-full bg-rose-100 text-rose-600 mr-4 ring-4 ring-rose-50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM17 11h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Left School</p>
                        <p class="text-3xl font-black text-gray-900">{{ $totalLeft }}</p>
                    </div>
                </div>

            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-3">Command Center</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <div>
                            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Student Ops
                            </h4>
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('students.create') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-indigo-50 border border-gray-200 hover:border-indigo-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">Add New Student</span>
                                    <span class="text-gray-400 group-hover:text-indigo-500">&rarr;</span>
                                </a>
                                <a href="{{ route('students.bulk-enroll') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-indigo-50 border border-gray-200 hover:border-indigo-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">Promote / Assign Classes</span>
                                    <span class="text-gray-400 group-hover:text-indigo-500">&rarr;</span>
                                </a>
                                <a href="{{ route('students.bulk-graduate') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-indigo-50 border border-gray-200 hover:border-indigo-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">Bulk Graduation</span>
                                    <span class="text-gray-400 group-hover:text-indigo-500">&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-emerald-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Finance & Fees
                            </h4>
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('fees.collect') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 hover:border-emerald-300 rounded-md transition duration-150 group">
                                    <span class="text-sm font-bold text-emerald-800 group-hover:text-emerald-900">Collect Payments (Desk)</span>
                                    <span class="text-emerald-500 group-hover:text-emerald-600">&rarr;</span>
                                </a>
                                <a href="{{ route('fees.generate') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-emerald-50 border border-gray-200 hover:border-emerald-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700">Generate Monthly Invoices</span>
                                    <span class="text-gray-400 group-hover:text-emerald-500">&rarr;</span>
                                </a>
                                <a href="{{ route('fees.structure') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-emerald-50 border border-gray-200 hover:border-emerald-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700">Manage Fee Structures</span>
                                    <span class="text-gray-400 group-hover:text-emerald-500">&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-purple-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Staff & System
                            </h4>
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('staff.create') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-purple-50 border border-gray-200 hover:border-purple-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-purple-700">Add New Staff</span>
                                    <span class="text-gray-400 group-hover:text-purple-500">&rarr;</span>
                                </a>
                                <a href="{{ route('staff.designations') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-purple-50 border border-gray-200 hover:border-purple-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-purple-700">Staff Designations</span>
                                    <span class="text-gray-400 group-hover:text-purple-500">&rarr;</span>
                                </a>
                                <a href="{{ route('settings.index') }}" wire:navigate class="flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-purple-50 border border-gray-200 hover:border-purple-200 rounded-md transition duration-150 group">
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-purple-700">Global Settings & Sessions</span>
                                    <span class="text-gray-400 group-hover:text-purple-500">&rarr;</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>