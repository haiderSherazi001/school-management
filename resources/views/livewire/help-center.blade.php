<div>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 tracking-tight leading-tight">
            {{ __('Help Center & User Manual') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8" x-data="{ activeSection: 'overview' }">
                
                <!-- Sidebar Navigation -->
                <div class="w-full md:w-1/4">
                    <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex flex-col gap-2 sticky top-24">
                        <div class="px-4 py-2 border-b border-gray-50 mb-2">
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Table of Contents</p>
                        </div>
                        
                        @php
                            $navItems = [
                                'overview' => ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Roles & Overview'],
                                'dashboard' => ['icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'label' => 'Admin Dashboard'],
                                'students' => ['icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14l9-5-9-5-9 5 9 5z', 'label' => 'Students & Academics'],
                                'staff' => ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'label' => 'Staff & HR'],
                                'classes' => ['icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z', 'label' => 'Classes Management'],
                                'finances' => ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Finances Module'],
                                'settings' => ['icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Global Settings'],
                                'workflows' => ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'label' => 'Key Workflows'],
                                'tips' => ['icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Troubleshooting'],
                            ];
                        @endphp
                        
                        @foreach($navItems as $key => $item)
                        <button @click="activeSection = '{{ $key }}'" 
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition duration-200 text-left font-bold text-sm"
                            :class="activeSection === '{{ $key }}' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-600 hover:bg-indigo-50 hover:text-indigo-700'">
                            <svg class="h-5 w-5 group-hover:text-indigo-600" :class="activeSection === '{{ $key }}' ? 'text-white' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                            </svg>
                            {{ $item['label'] }}
                            <svg x-cloak x-show="activeSection === '{{ $key }}'" class="w-4 h-4 ml-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="w-full md:w-3/4">
                    <div class="bg-white p-6 md:p-10 rounded-3xl shadow-sm border border-gray-100 min-h-[600px] relative overflow-hidden">
                        
                        <!-- Content: Overview -->
                        <div x-show="activeSection === 'overview'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-indigo-50 text-indigo-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">System Roles & Navigation Overview</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">Welcome to the EduFlow School Management System. This platform aims to seamlessly connect administration, academics, and finances into one accessible dashboard.</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
                                <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                    <h4 class="font-black text-gray-900 mb-2">Admin Profile</h4>
                                    <p class="text-sm text-gray-500 font-medium">Full access. Admins can manage the directories, dictate HR and Payroll operations, overview finances, and edit global system settings.</p>
                                </div>
                                <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                    <h4 class="font-black text-gray-900 mb-2">Staff Profile</h4>
                                    <p class="text-sm text-gray-500 font-medium">Accesses the Staff Portal to view assigned classes, grade students, and review personal attendance and payslips.</p>
                                </div>
                                <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                                    <h4 class="font-black text-gray-900 mb-2">Student Profile</h4>
                                    <p class="text-sm text-gray-500 font-medium">Accesses the Student Portal to check assigned classes, grades, report cards, and outstanding fee vouchers.</p>
                                </div>
                            </div>

                            <div class="mt-8 p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100 border-l-4 border-l-indigo-600">
                                <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-2">Navigating the App</h4>
                                <p class="text-sm text-indigo-800 font-medium">The Navigation Bar at the top is your primary compass. For Admins, it permanently provides clear jumps to the Dashboard, Students, Staff, Classes, and Settings. Your user profile menu on the right lets you check account settings or securely log out.</p>
                            </div>
                        </div>

                        <!-- Content: Dashboard -->
                        <div x-cloak x-show="activeSection === 'dashboard'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-rose-50 text-rose-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">The Admin Dashboard</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">The Admin Dashboard acts as the central hub of EduFlow.</p>
                            
                            <ul class="space-y-4 text-gray-600 font-medium">
                                <li class="flex items-start gap-4 p-4 rounded-xl bg-gray-50">
                                    <span class="w-8 h-8 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-black shrink-0">1</span>
                                    <div>
                                        <b class="text-gray-900 block mb-1">Monitor Statistics</b>
                                        View snapshot counts of active students, staff, upcoming exams, or high-level looks at pending fee collections across the system.
                                    </div>
                                </li>
                                <li class="flex items-start gap-4 p-4 rounded-xl bg-gray-50">
                                    <span class="w-8 h-8 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-black shrink-0">2</span>
                                    <div>
                                        <b class="text-gray-900 block mb-1">Financial Shortcuts</b>
                                        Under the analytics, you'll find direct links for logging day-to-day operations like <span class="bg-gray-200 px-2 py-0.5 rounded text-sm">Expenses</span>, <span class="bg-gray-200 px-2 py-0.5 rounded text-sm">Miscellaneous Income</span>, and accessing the <span class="bg-gray-200 px-2 py-0.5 rounded text-sm">Financial Ledger</span> to generate overarching reports.
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Content: Students -->
                        <div x-cloak x-show="activeSection === 'students'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-amber-50 text-amber-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">Student Management & Academics</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">The <b>Student Directory</b> holds the most features in the system. Beyond viewing profiles, you launch most operational workflows from here.</p>
                            
                            <div class="grid gap-6 md:grid-cols-2 mt-4">
                                <div class="border border-gray-100 p-5 rounded-2xl bg-amber-50/30">
                                    <h4 class="font-black text-amber-900 mb-3 text-lg">Managing Students</h4>
                                    <ul class="space-y-3 text-sm text-gray-600 font-medium">
                                        <li class="flex gap-2"><svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <b>Add Student:</b> Admits a new candidate and automatically generates their login credentials (e.g. Username 'STD-2026-00001' & Password based on DOB).</li>
                                        <li class="flex gap-2"><svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <b>Filters:</b> Sort by 'Active', 'Alumni', or 'Struck Off', or use the global search bar.</li>
                                    </ul>
                                </div>
                                <div class="border border-gray-100 p-5 rounded-2xl bg-emerald-50/30">
                                    <h4 class="font-black text-emerald-900 mb-3 text-lg">"More Operations" Dropdown</h4>
                                    <ul class="space-y-3 text-sm text-gray-600 font-medium">
                                        <li class="flex gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span> <b class="text-gray-900">Academics:</b> Contains links to enter exam marks, manage examination periods, trigger bulk student promotions, and execute bulk graduations.</li>
                                        <li class="flex gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span> <b class="text-gray-900">Finance:</b> Contains hooks to automatically generate fee vouchers for an entire class based on active structures, or to specifically search and register incoming fee collections from parents.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Content: Staff -->
                        <div x-cloak x-show="activeSection === 'staff'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-cyan-50 text-cyan-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">Staff Management & HR</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">The <b>Staff Directory</b> manages the workforce. Whether it's adding a new teacher, tracking their attendance, or managing payments, everything lands here.</p>
                            
                            <ul class="divide-y divide-gray-100 border-t border-b border-gray-100 mt-6">
                                <li class="py-4 flex gap-4">
                                    <div class="p-2 bg-gray-100 rounded-lg text-gray-500 shrink-0 mt-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                                    <div>
                                        <b class="text-gray-900 text-lg">Staff Registration</b>
                                        <p class="text-sm text-gray-500 font-medium md:max-w-xl pr-4 mt-1">Add an employee with a specified role. The system instantly creates a staff account using their CNIC as a secure initial password.</p>
                                    </div>
                                </li>
                                <li class="py-4 flex gap-4">
                                    <div class="p-2 bg-gray-100 rounded-lg text-gray-500 shrink-0 mt-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                    <div>
                                        <b class="text-gray-900 text-lg">HR Operations Dropdown</b>
                                        <p class="text-sm text-gray-500 font-medium md:max-w-xl pr-4 mt-1">This dropdown on the Staff Directory lets you access the <b>Generate Payroll</b> module, the <b>Attendance Marker</b>, and the central <b>Designation Manager</b> where roles and their default salaries are customized.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Content: Classes -->
                        <div x-cloak x-show="activeSection === 'classes'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-purple-50 text-purple-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">Classes Configuration</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">Under the <b>Classes</b> navigation option, Admins define the structural hierarchy of the institution.</p>
                            
                            <div class="mt-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <b>Adding a Class</b>
                                <p class="text-sm text-gray-600 mt-2 font-medium">
                                    When creating a class like "Class 6", you attach a "Numeric Value" (e.g. 6). The system uses this numeric value to securely know how to sort classes and who to promote when you trigger a bulk promotion at the end of the year. 
                                </p><br>
                                <p class="text-sm text-gray-600 font-medium">
                                    When a student is added to this class, their enrollment is strictly bound by the <span class="bg-gray-200 px-1 py-0.5 rounded text-xs text-black">Current Academic Session</span> global setting.
                                </p>
                            </div>
                        </div>

                        <!-- Content: Finances -->
                        <div x-cloak x-show="activeSection === 'finances'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-emerald-50 text-emerald-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">Finances Module</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">EduFlow handles all billing, expenses, and payroll natively. The Finances module consists of interconnected elements that report back to the central Profit/Loss page.</p>
                            
                            <div class="space-y-4 mt-6">
                                <div class="bg-emerald-50/50 border border-emerald-100 p-5 rounded-2xl">
                                    <h4 class="font-bold text-emerald-900 text-lg mb-2">1. Fee Structure & Collections</h4>
                                    <ul class="text-sm text-gray-600 space-y-2 mt-2">
                                        <li><span class="font-bold text-gray-900">Fee Structure Manager:</span> (Accessed via Students dropdown). Defines the recurring costs associated with each class (e.g., Tuition, Transport, Lab). Without this, bulk fee vouchers cannot generate!</li>
                                        <li><span class="font-bold text-gray-900">Generate Fees:</span> Takes the active Fee Structures and automatically builds a billing invoice for every currently active student enrolled in that module.</li>
                                        <li><span class="font-bold text-gray-900">Collect Fees:</span> The point-of-sale interface where incoming cash clears the outstanding vouchers and writes to the Ledger Income.</li>
                                    </ul>
                                </div>

                                <div class="bg-rose-50/50 border border-rose-100 p-5 rounded-2xl">
                                    <h4 class="font-bold text-rose-900 text-lg mb-2">2. Designations & Payroll</h4>
                                    <ul class="text-sm text-gray-600 space-y-2 mt-2">
                                        <li><span class="font-bold text-gray-900">Staff Designations:</span> Sets the default base salary expected for specific roles across the workforce.</li>
                                        <li><span class="font-bold text-gray-900">Generate Payroll:</span> Calculates net payouts by checking staff attendance against their base salaries. Processing this generates payslips and automatically deducts the amount from your Profit/Loss ledger as a recorded Expense.</li>
                                    </ul>
                                </div>

                                <div class="bg-gray-50 border border-gray-100 p-5 rounded-2xl">
                                    <h4 class="font-bold text-gray-900 text-lg mb-2">3. Manual Logging & Reports</h4>
                                    <ul class="text-sm text-gray-600 space-y-2 mt-2">
                                        <li><span class="font-bold text-gray-900">Income/Expense Logs:</span> Use the Dashboard shortcuts to log non-automated transactions (like paying a utility bill or receiving a sudden donation).</li>
                                        <li><span class="font-bold text-gray-900">Financial Reports:</span> The aggregate engine. Pick a date span to see your central Ledger combine all Fee Collections, logged Income, Payroll processing, and manual Expenses into one cohesive Profit/Loss document.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Content: Settings -->
                        <div x-cloak x-show="activeSection === 'settings'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-blue-50 text-blue-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">Global Settings</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">Core variables defining how the platform works.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-r-2xl">
                                    <h4 class="font-bold text-gray-900 text-sm">School Configuration</h4>
                                    <p class="text-xs text-gray-500 mt-2 font-medium">Update the school's name, email, address, and phone number shown heavily across generated vouchers and reports.</p>
                                </div>
                                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-2xl">
                                    <h4 class="font-bold text-red-900 text-sm">Academic Session</h4>
                                    <p class="text-xs text-red-700 mt-2 font-medium">Defines the current running year (e.g. 2026-2027). <br><br><b>Warning:</b> Altering this effectively transitions the school into the next year. Always ensure bulk promotion and graduation is completed before updating this string.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content: Workflows -->
                        <div x-cloak x-show="activeSection === 'workflows'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-teal-50 text-teal-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">Key Operations & Workflows</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">Understand the 'when' and 'why' behind major system functions to streamline your operations.</p>
                            
                            <div class="space-y-6 mt-6">
                                <div class="bg-gray-50 border border-gray-100 p-5 rounded-2xl relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition"><svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                    <h4 class="font-black text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        The End-of-Year Workflow (Promotions)
                                    </h4>
                                    <p class="text-sm text-gray-600 font-medium mb-1"><b>When:</b> Triggered at the end of the academic year once finals are graded.</p>
                                    <p class="text-sm text-gray-600 font-medium mb-4"><b>Why:</b> To migrate students en masse to their next respective class based on numeric class ordering, or graduate fully passing senior students to <span class="text-indigo-600 font-bold">Alumni status</span>.</p>
                                    <div class="text-xs bg-white border border-gray-200 py-3 px-4 rounded-xl font-medium text-gray-700 shadow-sm leading-relaxed">
                                        <span class="font-black text-gray-900 uppercase tracking-widest block mb-2 text-[10px]">How to execute:</span>
                                        1. Before changing the year, navigate to <b>Students</b> &rarr; <b>More Academics</b> and trigger <b>Bulk Graduation</b> to mark passing seniors as <span class="text-indigo-600 font-bold">Alumni</span>.<br>
                                        2. Go to <b>Global Settings</b> and update the <b>Academic Session</b> (e.g., from `2026-2027` to `2027-2028`). This locks the old year.<br>
                                        3. <span class="bg-amber-100 text-amber-800 font-bold px-1 rounded">NOTE:</span> The remaining active students will now correctly appear as <i>Unassigned</i> for the new year.<br>
                                        4. Finally, navigate to <b>More Operations</b> &rarr; <b>Promote Students</b>. Select the old class and map them into their new target class for the current session.
                                    </div>
                                </div>

                                <div class="bg-gray-50 border border-gray-100 p-5 rounded-2xl relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition"><svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                    <h4 class="font-black text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Monthly Finance Cycle (Fees & Payroll)
                                    </h4>
                                    <p class="text-sm text-gray-600 font-medium mb-1"><b>When:</b> Typically the first week and last week of the month.</p>
                                    <p class="text-sm text-gray-600 font-medium mb-4"><b>Why:</b> To standardize the generation of student fee vouchers for revenue collection, and process staff salaries securely via payroll.</p>
                                    <div class="text-xs bg-white border border-gray-200 py-3 px-4 rounded-xl font-medium text-gray-700 shadow-sm leading-relaxed">
                                        <span class="font-black text-gray-900 uppercase tracking-widest block mb-2 text-[10px]">How to execute:</span>
                                        1. <b>Fees:</b> Go to <b>Students</b> &rarr; <b>Generate Fees</b>. This references the class fee structures (e.g. Tuition vs Transport) to build printable vouchers for all active students.<br>
                                        2. <b>Collections:</b> Go to <b>Collect Fees</b> as parents make payments. Dashboard revenue stats will automatically update.<br>
                                        3. <b>Payroll:</b> At month-end, assure staff <i>Attendance</i> is marked, then go to <b>Staff</b> &rarr; <b>Generate Payroll</b> to calculate absences against base salaries and disburse payslips.
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 border border-gray-100 p-5 rounded-2xl relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition"><svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                                    <h4 class="font-black text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Examination & Grading
                                    </h4>
                                    <p class="text-sm text-gray-600 font-medium mb-4"><b>When:</b> During mid-terms, mid-sessions, or final examinations.</p>
                                    <div class="text-xs bg-white border border-gray-200 py-3 px-4 rounded-xl font-medium text-gray-700 shadow-sm leading-relaxed">
                                        <span class="font-black text-gray-900 uppercase tracking-widest block mb-2 text-[10px]">How to execute:</span>
                                        1. Admin navigates to <b>Exams</b> and registers a new examination period (e.g. <i>'Mid Terms 2026'</i>).<br>
                                        2. Teachers log into the portal and go to <b>Marks Entry</b> to securely assign scores out of the max threshold per subject.<br>
                                        3. Admin or Teachers can then view dynamically assembled student Report Cards that pull from these grading records!
                                    </div>
                                </div>

                                <div class="bg-gray-50 border border-gray-100 p-5 rounded-2xl relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition"><svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                                    <h4 class="font-black text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        Financial Ledger & Profit/Loss
                                    </h4>
                                    <p class="text-sm text-gray-600 font-medium mb-1"><b>When:</b> Ongoing daily logging; heavy review at month/year-end.</p>
                                    <p class="text-sm text-gray-600 font-medium mb-4"><b>Why:</b> To track all monetary flows beyond student fees and staff payroll, ensuring a clear picture of the institution's financial health via the Profit/Loss module.</p>
                                    <div class="text-xs bg-white border border-gray-200 py-3 px-4 rounded-xl font-medium text-gray-700 shadow-sm leading-relaxed">
                                        <span class="font-black text-gray-900 uppercase tracking-widest block mb-2 text-[10px]">How to execute:</span>
                                        1. <b>Daily Operations:</b> Use the Dashboard shortcuts to log day-to-day <b>Expenses</b> (e.g., utility bills, maintenance) and miscellaneous <b>Income</b> (e.g., uniform sales, donations).<br>
                                        2. <b>Ledger Review:</b> The system automatically merges your manual Income/Expense logs with the automated Fee Collections and Payroll payouts into a centralized Ledger.<br>
                                        3. <b>Profit/Loss Generation:</b> Navigate to the <b>Financial Reports</b> module on the Dashboard. Select a date range to generate a comprehensive Profit/Loss statement, which automatically calculates net revenue by offsetting total expenses (including payroll) against total income (including collected fees).
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Content: Tips -->
                        <div x-cloak x-show="activeSection === 'tips'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-orange-50 text-orange-600 mb-2">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">Troubleshooting & Tips</h3>
                            <p class="text-gray-600 text-lg leading-relaxed font-medium">Having trouble? Review these common roadblocks to fix issues faster.</p>
                            
                            <div class="space-y-4 mt-4">
                                <details class="group bg-gray-50 p-4 rounded-2xl border border-gray-100 cursor-pointer">
                                    <summary class="font-bold text-gray-900 flex justify-between items-center outline-none">
                                        Why is a student's class showing as "Unassigned"?
                                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 font-medium pl-2 border-l-2 border-indigo-200">
                                        The application looks for an enrollment matching the <span class="bg-gray-200 px-1 py-0.5 rounded text-xs text-black">Current Academic Session</span> configured in your Global Settings. If their admission date falls out of that bound or they haven't been enrolled in the new session, they appear Unassigned. Use Bulk Enrollment to fix this.
                                    </div>
                                </details>

                                <details class="group bg-gray-50 p-4 rounded-2xl border border-gray-100 cursor-pointer">
                                    <summary class="font-bold text-gray-900 flex justify-between items-center outline-none">
                                        Why won't my staff member record save?
                                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 font-medium pl-2 border-l-2 border-indigo-200">
                                        Check your data formatting validation! A CNIC requires exactly 13 digits (no dashes, e.g. <span class="tracking-widest">1234567890123</span>). A Phone Number expects an 11-digit entry (e.g. <span class="tracking-widest">03001234567</span>). Fixing dashes usually resolves the error.
                                    </div>
                                </details>

                                <details class="group bg-gray-50 p-4 rounded-2xl border border-gray-100 cursor-pointer">
                                    <summary class="font-bold text-gray-900 flex justify-between items-center outline-none">
                                        Can students access this platform?
                                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 font-medium pl-2 border-l-2 border-indigo-200">
                                        Yes! Provide them their system generated Username. By default, their password is <span class="font-mono text-gray-800 bg-gray-200 px-1 py-0.5 rounded text-xs">dob-YYYYMMDD</span> (e.g. <span class="font-mono text-gray-800 bg-gray-200 px-1 py-0.5 rounded text-xs">dob-20120521</span>). They will log in and only have access to their personal Student Portal without administrative powers.
                                    </div>
                                </details>

                                <details class="group bg-gray-50 p-4 rounded-2xl border border-gray-100 cursor-pointer">
                                    <summary class="font-bold text-gray-900 flex justify-between items-center outline-none">
                                        How do I reset a forgotten User Password?
                                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 font-medium pl-2 border-l-2 border-indigo-200">
                                        As an Admin, you cannot view raw passwords for security reasons. However, if a Staff member or Student gets locked out, you can navigate to their profile page in the directory, click the <b>Edit</b> button, and manually assign them a fresh password.
                                    </div>
                                </details>

                                <details class="group bg-gray-50 p-4 rounded-2xl border border-gray-100 cursor-pointer">
                                    <summary class="font-bold text-gray-900 flex justify-between items-center outline-none">
                                        Fee Vouchers aren't generating for a specific student?
                                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 font-medium pl-2 border-l-2 border-indigo-200">
                                        <ul class="list-disc pl-4 space-y-1">
                                            <li>Verify the student is marked as <b>Active</b> status. Alumni do not generate active fees.</li>
                                            <li>Ensure the student's assigned <b>Class</b> actually has active elements in the <b>Fee Structure Manager</b>. If a class has zero default configurations mapped to it, the system cannot generate billing automatically.</li>
                                        </ul>
                                    </div>
                                </details>

                                <details class="group bg-gray-50 p-4 rounded-2xl border border-gray-100 cursor-pointer">
                                    <summary class="font-bold text-gray-900 flex justify-between items-center outline-none">
                                        I accidentally marked Staff Attendance wrong. How do I fix it?
                                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 font-medium pl-2 border-l-2 border-indigo-200">
                                        The <b>Attendance Marker</b> allows you to edit entries up until the moment <b>Generate Payroll</b> is processed for that specific month. Simply change the date filter back to the day of the error and update the toggle before month-end payroll locks the data.
                                    </div>
                                </details>

                                <details class="group bg-gray-50 p-4 rounded-2xl border border-gray-100 cursor-pointer">
                                    <summary class="font-bold text-gray-900 flex justify-between items-center outline-none">
                                        Report Cards are showing '0' marks for certain subjects?
                                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 font-medium pl-2 border-l-2 border-indigo-200">
                                        This implies that the faculty member responsible for that subject has not yet submitted marks via the <b>Marks Entry</b> portal for the active exam period. The system requires an explicit numerical entry (even a zero) rather than leaving the field entirely blank.
                                    </div>
                                </details>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
