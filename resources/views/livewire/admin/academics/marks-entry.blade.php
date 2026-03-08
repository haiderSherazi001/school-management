<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academics: Marks Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 shadow-sm flex items-start">
                    <svg class="h-5 w-5 text-green-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Select Exam</label>
                        <select wire:model="exam_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                            <option value="">-- Choose Exam --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->academic_session }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Select Class</label>
                        <select wire:model.live="class_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                            <option value="">-- Choose Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} {{ $class->description ? '('. $class->description .')' : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Select Subject</label>
                        <select wire:model="subject_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium" {{ empty($subjects) ? 'disabled' : '' }}>
                            <option value="">-- Choose Subject --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} (Def: {{ $subject->total_marks }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <button wire:click="loadStudents" wire:loading.attr="disabled" class="w-full inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <span wire:loading.remove wire:target="loadStudents">Load Roster</span>
                            <span wire:loading wire:target="loadStudents">Loading...</span>
                        </button>
                    </div>

                </div>

                @if ($errors->any())
                    <div class="p-4 bg-red-50 border-b border-red-200">
                        <ul class="list-disc list-inside text-sm text-red-600 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($students))
                    <div class="p-6">
                        <div class="bg-indigo-50 border border-indigo-200 p-4 mb-6 rounded-md flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-sm">
                            <div>
                                <h4 class="text-sm font-bold text-indigo-900 uppercase tracking-wider">Exam Grading Scale</h4>
                                <p class="text-xs text-indigo-700 mt-1">Adjust the maximum marks for this specific exam if it differs from the default.</p>
                            </div>
                            <div class="flex items-center gap-3 bg-white p-2 rounded border border-indigo-100 shadow-sm">
                                <label class="text-sm font-bold text-gray-700 whitespace-nowrap">Total Marks:</label>
                                <input type="number" wire:model="exam_total_marks" class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-black text-center text-indigo-600">
                            </div>
                        </div>

                        <form wire:submit="saveMarks">
                            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-1/3">Student</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-1/6">Marks Obtained</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-1/6">Absent?</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-1/3">Remarks (Optional)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($students as $student)
                                            <tr class="hover:bg-gray-50 transition">
                                                
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="h-8 w-8 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm">
                                                            {{ substr($student->name, 0, 1) }}
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-bold text-gray-900">{{ $student->name }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                Roll No: {{ $student->studentProfile->roll_number ?? 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="number" step="0.01" wire:model="marksData.{{ $student->id }}.obtained_marks" placeholder="0.00" class="w-24 mx-auto text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-bold text-gray-900 disabled:bg-gray-100 disabled:text-gray-400" {{ $marksData[$student->id]['is_absent'] ? 'disabled' : '' }}>
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="checkbox" wire:model.live="marksData.{{ $student->id }}.is_absent" class="h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded cursor-pointer">
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="text" wire:model="marksData.{{ $student->id }}.remarks" placeholder="e.g. Needs to focus" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-700 disabled:bg-gray-100 disabled:text-gray-400" {{ $marksData[$student->id]['is_absent'] ? 'disabled' : '' }}>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center items-center py-2.5 px-8 border border-transparent shadow-md text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                    <span wire:loading.remove wire:target="saveMarks">Save All Marks</span>
                                    <span wire:loading wire:target="saveMarks">Saving Data...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif($class_id && $exam_id && $subject_id)
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-bold text-gray-900">No students found</h3>
                        <p class="mt-1 text-sm text-gray-500">There are no active students enrolled in this class for the current session.</p>
                    </div>
                @else
                    <div class="p-12 text-center bg-white">
                        <p class="text-sm font-medium text-gray-500">Please select an Exam, Class, and Subject, then click "Load Roster" to start entering marks.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>