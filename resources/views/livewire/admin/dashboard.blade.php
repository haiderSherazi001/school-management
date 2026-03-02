<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Center') }}
            </h2>
            <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">
                Active Session: {{ $currentSession }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-sm text-gray-500 mt-1">Here is what is happening at your school today.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Students</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalStudents }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Active Enrollments</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $enrolledStudents }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border {{ $unassignedStudents > 0 ? 'border-orange-300 bg-orange-50' : 'border-gray-100' }} flex items-center transition-colors">
                    <div class="p-3 rounded-full {{ $unassignedStudents > 0 ? 'bg-orange-200 text-orange-700' : 'bg-gray-100 text-gray-600' }} mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium {{ $unassignedStudents > 0 ? 'text-orange-800' : 'text-gray-500' }} mb-1">Unassigned Students</p>
                        <p class="text-3xl font-bold {{ $unassignedStudents > 0 ? 'text-orange-900' : 'text-gray-900' }}">{{ $unassignedStudents }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Staff</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalStaff }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Alumni</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalAlumni }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-rose-100 text-rose-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM17 11h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Left School</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalLeft }}</p>
                    </div>
                </div>

            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Links</h3>
                    <div class="flex flex-wrap gap-4">
                        
                        <a href="{{ route('students.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Add Student
                        </a>
                        
                        <a href="{{ route('students.bulk-enroll') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-md font-semibold text-xs text-emerald-700 uppercase tracking-widest shadow-sm hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Promote Students
                        </a>
                        
                        <a href="{{ route('students.bulk-graduate') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-rose-50 border border-rose-200 rounded-md font-semibold text-xs text-rose-700 uppercase tracking-widest shadow-sm hover:bg-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Bulk Graduation
                        </a>
                        
                        <a href="{{ route('settings.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-slate-50 border border-slate-200 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Change Session
                        </a>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>