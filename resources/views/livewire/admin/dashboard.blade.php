<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight leading-tight">
                {{ __('Admin Command Center') }}
            </h2>
            <div class="flex items-center gap-3">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="bg-white text-gray-700 text-sm font-bold px-4 py-1.5 rounded-full border border-gray-200 shadow-sm">
                    Session: <span class="text-indigo-600">{{ $currentSession }}</span>
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 rounded-2xl shadow-lg overflow-hidden relative">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-48 h-48 rounded-full bg-white opacity-5 mix-blend-overlay"></div>
                    <div class="absolute bottom-0 right-1/4 w-32 h-32 rounded-full bg-indigo-500 opacity-20 blur-2xl"></div>
                    
                    <div class="relative h-full p-8 flex flex-col justify-center">
                        <h3 class="text-3xl font-black text-white tracking-tight mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-indigo-100 font-medium text-sm md:text-base max-w-xl leading-relaxed">
                            Here is your daily system briefing for <span class="text-white font-bold bg-white/10 px-2 py-0.5 rounded">{{ $schoolName }}</span>. All systems are running smoothly.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border {{ ($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) ? 'border-red-200' : 'border-gray-200' }} overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-gray-100 {{ ($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) ? 'bg-red-50/50' : 'bg-gray-50/50' }}">
                        <h4 class="text-xs font-black uppercase tracking-widest flex items-center gap-2 {{ ($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) ? 'text-red-600' : 'text-gray-500' }}">
                            @if($unassignedStudents > 0 || $overdueInvoices > 0 || $staffOnLeave > 0) 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Action Required 
                            @else 
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                All Clear 
                            @endif
                        </h4>
                    </div>
                    <div class="p-5 flex-1 bg-white">
                        @if($unassignedStudents == 0 && $overdueInvoices == 0 && $staffOnLeave == 0)
                            <div class="flex flex-col items-center justify-center h-full text-center">
                                <p class="text-sm font-bold text-gray-400">There are no pending alerts for today. Great job!</p>
                            </div>
                        @else
                            <ul class="text-sm font-medium text-gray-700 space-y-3">
                                @if($unassignedStudents > 0)
                                    <li class="flex items-start gap-2 bg-red-50 text-red-800 p-2 rounded-md border border-red-100"><span class="mt-0.5 text-red-500">&bull;</span> {{ $unassignedStudents }} student(s) unassigned.</li>
                                @endif
                                @if($overdueInvoices > 0)
                                    <li class="flex items-start gap-2 bg-orange-50 text-orange-800 p-2 rounded-md border border-orange-100"><span class="mt-0.5 text-orange-500">&bull;</span> {{ $overdueInvoices }} fee invoice(s) overdue.</li>
                                @endif
                                @if($staffOnLeave > 0)
                                    <li class="flex items-start gap-2 bg-blue-50 text-blue-800 p-2 rounded-md border border-blue-100"><span class="mt-0.5 text-blue-500">&bull;</span> {{ $staffOnLeave }} staff on leave.</li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
                    <div class="relative">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 rounded-xl bg-blue-100 text-blue-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-gray-900">{{ $totalStudents }}</p>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Total Students</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
                    <div class="relative">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 rounded-xl bg-purple-100 text-purple-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-gray-900">{{ $activeStaff }}</p>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Active Staff</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
                    <div class="relative">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 rounded-xl bg-emerald-100 text-emerald-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <p class="text-2xl lg:text-3xl font-black text-gray-900"><span class="text-lg text-gray-400 font-bold mr-1">Rs.</span>{{ number_format($collectedThisMonth) }}</p>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Collected This Month</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
                    <div class="relative">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 rounded-xl bg-orange-100 text-orange-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <p class="text-2xl lg:text-3xl font-black text-gray-900"><span class="text-lg text-gray-400 font-bold mr-1">Rs.</span>{{ number_format($pendingDues) }}</p>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Pending Dues</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-5 bg-white border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900">Student Enrollments</h3>
                        <span class="text-xs font-black text-blue-700 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">{{ $enrolledStudents }} Total</span>
                    </div>
                    <div class="p-6 max-h-80 overflow-y-auto bg-gray-50/30 flex-1">
                        <div class="space-y-5">
                            @forelse($classBreakdown as $class)
                                @if($class->enrollments_count > 0)
                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-gray-700">{{ $class->name }} @if($class->description) <span class="text-gray-400 font-medium">({{ $class->description }})</span> @endif</span>
                                            <span class="text-gray-900 font-black">{{ $class->enrollments_count }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ ($class->enrollments_count / max($enrolledStudents, 1)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm text-gray-500 text-center py-8 font-medium">No active enrollments found for this session.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-5 bg-white border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900">Staff by Role</h3>
                        <span class="text-xs font-black text-purple-700 bg-purple-50 border border-purple-100 px-3 py-1 rounded-full">{{ $activeStaff }} Total</span>
                    </div>
                    <div class="p-6 max-h-80 overflow-y-auto bg-gray-50/30 flex-1">
                        <div class="space-y-5">
                            @forelse($staffBreakdown as $role)
                                @if($role->staff_profiles_count > 0)
                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-gray-700">{{ $role->title }}</span>
                                            <span class="text-gray-900 font-black">{{ $role->staff_profiles_count }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-purple-500 h-2.5 rounded-full" style="width: {{ ($role->staff_profiles_count / max($activeStaff, 1)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm text-gray-500 text-center py-8 font-medium">No active staff members found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Quick Actions
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        
                        <div>
                            <h4 class="text-xs font-black text-blue-600 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Student Ops</h4>
                            <div class="flex flex-col gap-2.5">
                                <a href="{{ route('students.create') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-blue-50 hover:text-blue-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Add New Student
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('students.bulk-enroll') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-blue-50 hover:text-blue-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Promote / Assign Classes
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('students.bulk-graduate') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-blue-50 hover:text-blue-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Bulk Graduation
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Academics</h4>
                            <div class="flex flex-col gap-2.5">
                                <a href="{{ route('academics.marks') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-indigo-50 hover:text-indigo-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Marks Entry
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a> 
                                <a href="{{ route('academics.exams') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-indigo-50 hover:text-indigo-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Manage Exams
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a> 
                                <a href="{{ route('academics.subjects') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-indigo-50 hover:text-indigo-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Manage Subjects
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('academics.reports') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-indigo-50 hover:text-indigo-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Report Cards
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a> 
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Finance & Fees</h4>
                            <div class="flex flex-col gap-2.5">
                                <a href="{{ route('fees.collect') }}" wire:navigate class="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 hover:text-emerald-800 border border-emerald-100 text-sm font-bold text-emerald-700 rounded-lg transition duration-200 flex justify-between items-center group shadow-sm">
                                    Collect Payments (Desk)
                                    <svg class="w-4 h-4 text-emerald-500 group-hover:text-emerald-700 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('fees.generate') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-emerald-50 hover:text-emerald-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Generate Monthly Invoices
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('fees.structure') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-emerald-50 hover:text-emerald-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Manage Fee Structures
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('reports.financial') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-emerald-50 hover:text-emerald-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Financial Ledger
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-purple-600 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Staff & System</h4>
                            <div class="flex flex-col gap-2.5">
                                <a href="{{ route('payroll.generate') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-purple-50 hover:text-purple-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Run Monthly Payroll
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('hr.attendance') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-purple-50 hover:text-purple-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Mark Attendance
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a> 
                                <a href="{{ route('staff.create') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-purple-50 hover:text-purple-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Add New Staff
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('settings.index') }}" wire:navigate class="px-4 py-2.5 bg-gray-50 hover:bg-purple-50 hover:text-purple-700 text-sm font-bold text-gray-700 rounded-lg transition duration-200 flex justify-between items-center group">
                                    Global Settings
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>