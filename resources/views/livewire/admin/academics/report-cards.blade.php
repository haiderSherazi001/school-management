<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academics: Report Cards') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="w-full md:w-2/5">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Select Exam</label>
                        <select wire:model="exam_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                            <option value="">-- Choose Exam --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->academic_session }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-2/5">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Select Class</label>
                        <select wire:model="class_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                            <option value="">-- Choose Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} {{ $class->description? '('. $class->description .')' : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/5">
                        <button wire:click="loadStudents" wire:loading.attr="disabled" class="w-full inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                            <span wire:loading.remove wire:target="loadStudents">Generate List</span>
                            <span wire:loading wire:target="loadStudents">Loading...</span>
                        </button>
                    </div>

                </div>

                @if(!empty($students))
                    <div class="p-0 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Roll Number</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students as $student)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $student->studentProfile->roll_number ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('academics.print-report', ['exam' => $exam_id, 'student' => $student->id]) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded text-xs font-bold text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                Print Report
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif($exam_id && $class_id)
                    <div class="p-12 text-center text-gray-500 font-medium">No students found in this class.</div>
                @else
                    <div class="p-12 text-center text-gray-500 font-medium">Select an Exam and Class to view the printable report cards.</div>
                @endif

            </div>
        </div>
    </div>
</div>