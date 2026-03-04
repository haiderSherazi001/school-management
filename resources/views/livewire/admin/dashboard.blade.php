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
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="h-full p-6 sm:p-8 text-gray-900 flex flex-col justify-center bg-gradient-to-r from-white to-indigo-50/30">
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-sm font-medium text-gray-500 mt-2">Here is your daily briefing for <span class="text-indigo-600 font-bold">{{ $schoolName }}</span>.</p>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg border {{ ($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) ? 'border-red-300' : 'border-gray-200' }}">
                    <div class="h-full p-6 {{ ($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) ? 'bg-red-50' : 'bg-gray-50' }}">
                        <h4 class="text-sm font-bold uppercase tracking-wider mb-3 flex items-center gap-2 {{ ($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) ? 'text-red-800' : 'text-gray-500' }}">
                            @if($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) ⚠️ Action Required @else ✅ All Clear @endif
                        </h4>
                        
                        @if($unassignedStudents == 0 && $overdueInvoices == 0 && $staffOnLeave == 0)
                            <p class="text-sm text-gray-500">There are no pending alerts for today. Great job!</p>
                        @else
                            <ul class="text-sm text-red-700 space-y-2">
                                @if($unassignedStudents > 0)
                                    <li class="flex items-start gap-2"><span class="mt-0.5">&bull;</span> {{ $unassignedStudents }} student(s) have not been assigned to a class.</li>
                                @endif
                                @if($overdueInvoices > 0)
                                    <li class="flex items-start gap-2"><span class="mt-0.5">&bull;</span> {{ $overdueInvoices }} fee invoice(s) are past their due date.</li>
                                @endif
                                @if($staffOnLeave > 0)
                                    <li class="flex items-start gap-2"><span class="mt-0.5">&bull;</span> {{ $staffOnLeave }} staff member(s) are currently on leave.</li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col hover:shadow-md transition duration-200">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-md bg-blue-100 text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Students</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $totalStudents }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col hover:shadow-md transition duration-200">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-md bg-purple-100 text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Active Staff</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $activeStaff }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col hover:shadow-md transition duration-200">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-md bg-emerald-100 text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Collected This Month</p>
                    </div>
                    <p class="text-2xl md:text-3xl font-black text-emerald-600">Rs. {{ number_format($collectedThisMonth) }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col hover:shadow-md transition duration-200">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-md bg-orange-100 text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pending Dues</p>
                    </div>
                    <p class="text-2xl md:text-3xl font-black text-orange-600">Rs. {{ number_format($pendingDues) }}</p>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Student Enrollments by Class</h3>
                        <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-1 rounded">{{ $enrolledStudents }} Total</span>
                    </div>
                    <div class="p-5 max-h-72 overflow-y-auto">
                        <div class="space-y-4">
                            @forelse($classBreakdown as $class)
                                @if($class->enrollments_count > 0)
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-semibold text-gray-700">{{ $class->name }} @if($class->description) ({{ $class->description }}) @endif</span>
                                            <span class="text-gray-600 font-bold">{{ $class->enrollments_count }}</span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($class->enrollments_count / max($enrolledStudents, 1)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">No active enrollments found for this session.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Active Staff by Role</h3>
                        <span class="text-xs font-bold text-purple-700 bg-purple-100 px-2 py-1 rounded">{{ $activeStaff }} Total</span>
                    </div>
                    <div class="p-5 max-h-72 overflow-y-auto">
                        <div class="space-y-4">
                            @forelse($staffBreakdown as $role)
                                @if($role->staff_profiles_count > 0)
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-semibold text-gray-700">{{ $role->title }}</span>
                                            <span class="text-gray-600 font-bold">{{ $role->staff_profiles_count }}</span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-2">
                                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ ($role->staff_profiles_count / max($activeStaff, 1)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">No active staff members found.</p>
                            @endforelse
                        </div>
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