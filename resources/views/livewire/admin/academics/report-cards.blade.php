<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Dashboard
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Report Card Dispatch') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-indigo-600"></div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
                
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">1. Select Target Exam</label>
                    <select wire:model="exam_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700">
                        <option value="">-- Choose Exam --</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->academic_session }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">2. Select Class Registry</label>
                    <select wire:model="class_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-gray-700">
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} {{ $class->description ? '('. $class->description .')' : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button wire:click="loadStudents" wire:loading.attr="disabled" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md transition uppercase tracking-widest text-xs">
                        <span wire:loading.remove wire:target="loadStudents">Generate List</span>
                        <span wire:loading wire:target="loadStudents">
                            <svg class="animate-spin h-4 w-4 mx-auto text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        @if(!empty($students))
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up">
                <div class="px-8 py-5 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Student Results Roster</h3>
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-[10px] font-black uppercase border border-indigo-100">
                        Total: {{ count($students) }} Students
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/30">
                            <tr class="text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-8 py-4">Student Identity</th>
                                <th class="px-8 py-4">System Identifier</th>
                                <th class="px-8 py-4 text-right">Dispatch Report</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($students as $student)
                                <tr class="hover:bg-indigo-50/20 transition group">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-black text-xs border border-gray-200 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-500 transition-all duration-300">
                                                {{ substr($student->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-black text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $student->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-xs font-black text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100 uppercase tracking-widest">
                                            Roll: {{ $student->studentProfile->roll_number ?? '---' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right">
                                        <a href="{{ route('academics.print-report', ['exam' => $exam_id, 'student' => $student->id]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-[10px] font-black text-gray-600 uppercase tracking-widest shadow-sm hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-200 group/btn">
                                            <svg class="w-4 h-4 text-gray-400 group-hover/btn:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Print Report
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($exam_id && $class_id)
            <div class="bg-white rounded-2xl border border-gray-100 p-20 text-center shadow-sm">
                <div class="p-4 bg-indigo-50 rounded-full inline-block mb-4 text-indigo-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-base font-black text-gray-900 uppercase tracking-widest">No Students Found</h3>
                <p class="text-sm text-gray-400 mt-1">There are no active students enrolled in this class for the selected session.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 p-20 text-center shadow-sm">
                <div class="p-4 bg-gray-50 rounded-full inline-block mb-4 text-gray-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-base font-black text-gray-900 uppercase tracking-widest">Dispatch Center</h3>
                <p class="text-sm text-gray-400 mt-1">Select an Exam and Class above to generate printable report cards for your students.</p>
            </div>
        @endif

    </div>
</div>