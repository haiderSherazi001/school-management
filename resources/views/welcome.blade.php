<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduFlow ERP | Smart School Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-gray-900">Edu<span class="text-indigo-600">Flow</span></span>
                </div>
                
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition">Features</a>
                    <a href="#academics" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition">Academics</a>
                    <a href="#finance" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition">Finance</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="text-sm font-bold text-gray-700 hover:text-indigo-600 transition">Login</a>
                        
                        <a href="{{ route('register') }}" wire:navigate class="bg-gray-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-600 transition shadow-lg shadow-gray-200">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest bg-indigo-50 text-indigo-700 border border-indigo-100 mb-6">
                    🚀 The Next-Gen School ERP
                </span>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 tracking-tight mb-8">
                    Manage your school with <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">zero friction.</span>
                </h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                    A unified workspace for student admissions, staff payroll, academic grading, and financial tracking. Built for modern institutions that value efficiency.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition duration-200">
                        Launch Dashboard
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition">
                        Explore Features
                    </a>
                </div>
            </div>

            <div class="mt-20 relative">
                <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent z-10"></div>
                <div class="rounded-3xl border border-gray-200 p-2 bg-gray-50/50 shadow-2xl overflow-hidden animate-fade-in-up">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-inner overflow-hidden aspect-[16/9] flex items-center justify-center text-gray-300">
                        {{-- Replace this with an actual screenshot of your dashboard later --}}
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 21h6l-.75-4M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p class="font-black uppercase tracking-widest text-sm opacity-20">Secure ERP Environment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-16">
                <div class="max-w-xl text-left">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-600 mb-3">Core Modules</h2>
                    <p class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">Everything you need to run a high-performance school.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Identity Management</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Full lifecycle management for students and staff. Handle admissions, profiles, and digital document archiving in one click.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Vertical Academics</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">A specialized performance entry matrix. Input subject marks, manage exam schedules, and generate report cards instantly.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">Finance Desktop</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Automated fee generation and a dedicated collection desk. Real-time defaulter lists and automated receipt printing.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl lg:text-5xl font-black text-gray-900 tracking-tight leading-tight mb-8 text-center sm:text-left">
                        Performance-driven architecture <br>
                        <span class="text-indigo-600">Built for scale.</span>
                    </h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="mt-1 flex-shrink-0 w-6 h-6 text-indigo-600"><svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></div>
                            <div>
                                <h4 class="font-bold text-gray-900">TALL Stack Foundation</h4>
                                <p class="text-sm text-gray-500">Built on Tailwind, Alpine, Laravel, and Livewire for a reactive, seamless user experience.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="mt-1 flex-shrink-0 w-6 h-6 text-indigo-600"><svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></div>
                            <div>
                                <h4 class="font-bold text-gray-900">Security First</h4>
                                <p class="text-sm text-gray-500">Role-based access control ensuring sensitive financial and academic data is always protected.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-indigo-600 rounded-3xl p-8 text-center text-white">
                        <div class="text-4xl font-black mb-2">100%</div>
                        <p class="text-xs font-bold uppercase tracking-widest opacity-80">Digital Records</p>
                    </div>
                    <div class="bg-gray-100 rounded-3xl p-8 text-center text-gray-900">
                        <div class="text-4xl font-black mb-2">0</div>
                        <p class="text-xs font-bold uppercase tracking-widest opacity-60 text-gray-500">Paper Friction</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-[3rem] p-12 lg:p-20 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 blur-[100px]"></div>
                <h2 class="text-3xl lg:text-5xl font-extrabold text-white mb-8 tracking-tight">Ready to modernize your institution?</h2>
                <p class="text-indigo-200/60 max-w-lg mx-auto mb-10 text-sm lg:text-base font-medium">Join schools that are simplifying their management today with our integrated ERP solutions.</p>
                <a href="{{ route('login') }}" class="inline-block px-10 py-4 bg-white text-gray-900 font-black rounded-2xl hover:bg-indigo-50 hover:scale-105 transition-all duration-200 uppercase tracking-widest text-xs">
                    Get Started Now
                </a>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-lg font-extrabold tracking-tight text-gray-900">EduFlow</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">© {{ date('Y') }} EduFlow ERP System. Built with the TALL Stack.</p>
            </div>
        </div>
    </footer>

</body>
</html>