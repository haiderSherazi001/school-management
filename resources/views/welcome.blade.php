<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduFlow | Comprehensive School Management System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

    <header class="bg-white/90 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-md flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900">EduFlow</span>
                </div>

                <nav class="hidden md:flex space-x-8">
                    <a href="#finance" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">Finance</a>
                    <a href="#academics" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">Academics</a>
                    <a href="#hr" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">HR & Staff</a>
                    <a href="#contact" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">Contact Sales</a>
                </nav>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate class="text-sm font-bold text-indigo-600 hover:text-indigo-800">Go to Dashboard &rarr;</a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors hidden sm:block">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gray-900 hover:bg-indigo-600 transition-all duration-200">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <section class="bg-gray-50 py-20 lg:py-32 border-b border-gray-200 overflow-hidden relative">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-indigo-50 blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-50 blur-3xl opacity-50 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold tracking-widest uppercase mb-6 border border-indigo-200">
                The Standard in School Management
            </span>
            <h1 class="text-5xl tracking-tight font-extrabold text-gray-900 sm:text-6xl md:text-7xl mb-6">
                Run your entire school from <br class="hidden lg:block">
                <span class="text-indigo-600">one intelligent platform.</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-500 leading-relaxed">
                Eliminate administrative bottlenecks. EduFlow centralizes student records, automates fee collection, manages staff payroll, and simplifies academic grading.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transition-colors">
                        Access Your Workspace
                    </a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transition-colors">
                            Initialize Your School
                        </a>
                    @endif
                    <a href="#contact" class="inline-flex items-center justify-center px-8 py-4 border border-gray-300 text-base font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-colors">
                        Request a Demo
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <section id="finance" class="py-24 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-12 lg:mb-0 pr-0 lg:pr-8">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase mb-2">Financial Desktop</h2>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl mb-6">
                        Enterprise-grade cash flow management.
                    </h3>
                    <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                        Our Point-of-Sale style financial desk transforms how your accounting office operates. Ditch the spreadsheets and manage all payments directly within the browser.
                    </p>
                    
                    <ul class="space-y-5">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Instant Defaulter Tracking</h4>
                                <p class="mt-1 text-sm text-gray-500">A live sidebar continuously tracks pending payments and highlights defaulting students.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Ad-Hoc Billing & Surcharges</h4>
                                <p class="mt-1 text-sm text-gray-500">Apply instant custom charges (like library fines or ID card replacements) directly to a student's ledger.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="relative bg-white border border-gray-200 rounded-2xl shadow-xl p-6">
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-orange-100 rounded-full blur-2xl opacity-60"></div>
                    <div class="border-b border-gray-100 pb-4 mb-4 flex justify-between items-center">
                        <div class="h-6 w-32 bg-gray-200 rounded"></div>
                        <div class="h-8 w-24 bg-indigo-50 border border-indigo-100 rounded flex items-center justify-center">
                            <div class="h-2 w-16 bg-indigo-200 rounded"></div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 rounded-lg flex justify-between items-center border border-gray-100">
                            <div>
                                <div class="h-4 w-24 bg-gray-300 rounded mb-2"></div>
                                <div class="h-3 w-16 bg-gray-200 rounded"></div>
                            </div>
                            <div class="h-8 w-20 bg-orange-50 border border-orange-100 rounded flex items-center justify-center">
                                <div class="h-2 w-12 bg-orange-300 rounded"></div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg flex justify-between items-center border border-gray-100">
                            <div>
                                <div class="h-4 w-24 bg-gray-300 rounded mb-2"></div>
                                <div class="h-3 w-16 bg-gray-200 rounded"></div>
                            </div>
                            <div class="h-8 w-20 bg-emerald-50 border border-emerald-100 rounded flex items-center justify-center">
                                <div class="h-2 w-12 bg-emerald-300 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="academics" class="py-24 bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center flex flex-col-reverse">
                
                <div class="mt-12 lg:mt-0 relative bg-white border border-gray-200 rounded-2xl shadow-xl p-6">
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-blue-100 rounded-full blur-2xl opacity-60"></div>
                    <div class="grid grid-cols-4 gap-4 mb-4 pb-4 border-b border-gray-100">
                        <div class="h-3 bg-gray-300 rounded col-span-2"></div>
                        <div class="h-3 bg-gray-300 rounded text-center"></div>
                        <div class="h-3 bg-gray-300 rounded text-center"></div>
                    </div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-4 gap-4 items-center">
                            <div class="h-4 bg-gray-200 rounded col-span-2"></div>
                            <div class="h-6 border border-gray-200 rounded text-center"></div>
                            <div class="h-6 border border-gray-200 rounded text-center"></div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 items-center">
                            <div class="h-4 bg-gray-200 rounded col-span-2"></div>
                            <div class="h-6 border border-gray-200 rounded text-center"></div>
                            <div class="h-6 border border-gray-200 rounded text-center"></div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 items-center pt-4">
                            <div class="col-span-2"></div>
                            <div class="h-8 bg-indigo-600 rounded col-span-2 flex items-center justify-center">
                                <div class="h-2 w-16 bg-white/50 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pl-0 lg:pl-8">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase mb-2">Academics Dispatch</h2>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl mb-6">
                        Frictionless result processing.
                    </h3>
                    <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                        Transition from messy paper ledgers to a highly structured digital gradebook. We've optimized the data entry process to make end-of-term grading a breeze for educators.
                    </p>
                    
                    <ul class="space-y-5">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Mass Report Card Dispatch</h4>
                                <p class="mt-1 text-sm text-gray-500">Filter by class and exam session to instantly view rosters and dispatch printable report cards.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Custom Absentee Handling</h4>
                                <p class="mt-1 text-sm text-gray-500">Dedicated toggles specifically designed to handle absent students during examination entries without breaking calculations.</p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <section id="hr" class="py-24 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-12 lg:mb-0 pr-0 lg:pr-8">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase mb-2">Human Resources</h2>
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl mb-6">
                        Manage your most valuable assets.
                    </h3>
                    <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                        A dedicated HR module built directly into the ERP. Securely manage teaching faculty and administrative staff, handle role assignments, and streamline payroll data.
                    </p>
                    
                    <ul class="space-y-5">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Digital Staff Dossiers</h4>
                                <p class="mt-1 text-sm text-gray-500">Maintain comprehensive digital records for every employee, including contact info, joining dates, and base salaries.</p>
                            </div>
                        </li>
                        
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Leave & Attendance Tracking</h4>
                                <p class="mt-1 text-sm text-gray-500">Monitor daily staff availability with ease. Review digital leave requests, track absence quotas, and maintain accurate attendance records for term evaluations.</p>
                            </div>
                        </li>

                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-bold text-gray-900">Automated Payroll Processing</h4>
                                <p class="mt-1 text-sm text-gray-500">Streamline monthly salary disbursements. Easily track base pay, calculate deductions or bonuses, and generate standardized digital payslips for your entire faculty.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="relative bg-white border border-gray-200 rounded-2xl shadow-xl p-6">
                    <div class="absolute -top-4 -right-4 w-32 h-32 bg-indigo-100 rounded-full blur-2xl opacity-60"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                        <div>
                            <div class="h-4 w-32 bg-gray-300 rounded mb-2"></div>
                            <div class="h-3 w-20 bg-indigo-100 rounded"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                        <div>
                            <div class="h-4 w-24 bg-gray-300 rounded mb-2"></div>
                            <div class="h-3 w-16 bg-emerald-100 rounded"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                        <div>
                            <div class="h-4 w-28 bg-gray-300 rounded mb-2"></div>
                            <div class="h-3 w-24 bg-indigo-100 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-24 bg-gray-900 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-indigo-900/20 blur-[120px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                
                <div class="mb-12 lg:mb-0">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl mb-4">
                        Ready to modernize your institution?
                    </h2>
                    <p class="text-lg text-indigo-200 mb-8 leading-relaxed">
                        Whether you need a live demonstration, have questions about data migration, or want to discuss enterprise pricing, our team is ready to help.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center text-indigo-100">
                            <svg class="w-6 h-6 mr-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>mrhyder29@gmail.com</span>
                        </div>
                        <div class="flex items-center text-indigo-100">
                            <svg class="w-6 h-6 mr-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+92 343 1830998</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-2xl">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Request a Demo</h3>
                    <livewire:frontend.contact-form />
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-50 border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gray-900 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-gray-900">EduFlow</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Providing robust, scalable enterprise resource planning for modern educational institutions worldwide.
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Platform</h4>
                    <ul class="space-y-3">
                        <li><a href="#finance" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">Financial Desk</a></li>
                        <li><a href="#academics" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">Academic Dispatch</a></li>
                        <li><a href="#hr" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">HR & Staffing</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">Employee Portal</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">API Documentation</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">System Status</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">Data Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} EduFlow. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>