<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Dashboard
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Student Performance Entry') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        @if (session()->has('success'))
            {{-- Added x-init here to trigger the scroll --}}
            <div x-data="{ show: true }" 
                 x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })"
                 x-show="show" 
                 x-transition 
                 class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start">
                <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold text-emerald-800 flex-1">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-indigo-600"></div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">1. Select Exam</label>
                    <select wire:model="exam_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700">
                        <option value="">-- Choose Exam --</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->academic_session }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">2. Select Class</label>
                    <select wire:model.live="class_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700">
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} {{ $class->description ? '('. $class->description .')' : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">3. Select Student</label>
                    <select wire:model="student_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700" {{ empty($students) ? 'disabled' : '' }}>
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->studentProfile->roll_number }})</option>
                        @endforeach
                    </select>
                </div>

                <button wire:click="loadStudentRoster" wire:loading.attr="disabled" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md transition uppercase tracking-widest text-xs">
                    <span wire:loading.remove wire:target="loadStudentRoster">Load Subjects</span>
                    <span wire:loading wire:target="loadStudentRoster">Loading...</span>
                </button>
            </div>
        </div>

        @if(!empty($marksData))
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up">
                <div class="px-8 py-5 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Subject-Wise Grading</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Academic Session: {{ $currentSession }}</p>
                </div>

                <form wire:submit="saveStudentMarks">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/30">
                                <tr class="text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="px-8 py-4 w-1/3">Subject Name</th>
                                    <th class="px-8 py-4 text-center">Max Marks</th>
                                    <th class="px-8 py-4 text-center">Marks Obtained</th>
                                    <th class="px-8 py-4 text-center">Attendance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($subjects as $subject)
                                    <tr class="hover:bg-indigo-50/20 transition group" wire:key="sub-{{ $subject->id }}">
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <div class="text-sm font-black text-gray-900 group-hover:text-indigo-600 transition">{{ $subject->name }}</div>
                                        </td>

                                        <td class="px-8 py-5 whitespace-nowrap text-center">
                                            <input type="number" wire:model="marksData.{{ $subject->id }}.total" class="w-20 mx-auto text-center rounded-lg border-gray-200 bg-gray-50 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition sm:text-xs font-black text-gray-800">
                                        </td>

                                        <td class="px-8 py-5 whitespace-nowrap text-center">
                                            <input 
                                                type="number" 
                                                step="0.01" 
                                                wire:model="marksData.{{ $subject->id }}.obtained" 
                                                placeholder="marks" 
                                                class="w-28 mx-auto text-center rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-black text-gray-900 {{ $marksData[$subject->id]['is_absent'] ? 'bg-gray-100 text-gray-300 cursor-not-allowed' : '' }}"
                                                {{ $marksData[$subject->id]['is_absent'] ? 'disabled' : '' }}
                                            >
                                        </td>

                                        <td class="px-8 py-5 whitespace-nowrap text-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model.live="marksData.{{ $subject->id }}.is_absent" class="sr-only peer">
                                                <div class="w-11 h-6 bg-emerald-100 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500"></div>
                                                <span class="ms-3 text-[10px] font-black uppercase {{ $marksData[$subject->id]['is_absent'] ? 'text-red-600' : 'text-emerald-600' }}">
                                                    {{ $marksData[$subject->id]['is_absent'] ? 'Absent' : 'Present' }}
                                                </span>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex justify-end items-center gap-6">
                        <p class="text-[10px] font-bold text-gray-400 italic">Verify all entries before final synchronization.</p>
                        <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 px-10 rounded-xl shadow-lg shadow-indigo-100 transition uppercase tracking-widest text-xs">
                            <span wire:loading.remove wire:target="saveStudentMarks">Update Student Marks</span>
                            <span wire:loading wire:target="saveStudentMarks" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Syncing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 p-20 text-center shadow-sm">
                <div class="p-4 bg-indigo-50 rounded-full inline-block mb-4 text-indigo-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-base font-black text-gray-900 uppercase tracking-widest">No Student Selected</h3>
                <p class="text-sm text-gray-400 mt-1">Please configure the filters above to load the subject-wise marks entry list.</p>
            </div>
        @endif

    </div>
</div>