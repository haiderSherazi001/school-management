<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $student->name }} - {{ $exam->name }} Report Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
            .no-print { display: none !important; }
            @page { margin: 0.5cm; size: A4 portrait; }
        }
    </style>
</head>
<body class="bg-gray-200 text-gray-900 font-sans p-4 print:p-0 print:bg-white" onload="window.print()">

    <div class="no-print max-w-4xl mx-auto mb-6 bg-gray-800 text-white p-4 rounded-lg flex justify-between items-center shadow-lg">
        <div>
            <h1 class="font-bold text-lg">Report Card Preview</h1>
            <p class="text-sm text-gray-400">Press Ctrl+P to print. Ensure "Background Graphics" is turned on in print settings.</p>
        </div>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-500 px-6 py-2 rounded font-bold shadow transition">
            Print Document
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-8 border-4 border-gray-900 print:border-none print:shadow-none shadow-xl relative">
        
        <div class="text-center border-b-4 border-gray-900 pb-6 mb-6">
            <h1 class="text-4xl font-black uppercase tracking-widest text-gray-900">
                {{ \App\Models\Setting::get('school_name', 'YOUR SCHOOL NAME') }}
            </h1>
            <p class="text-md font-medium text-gray-600 mt-2">
                {{ \App\Models\Setting::get('school_address', '123 Main Education Road, City') }}
            </p>
            <div class="mt-4 inline-block bg-gray-900 text-white px-6 py-2 rounded-full text-lg font-bold uppercase tracking-widest shadow-md">
                Official Report Card
            </div>
        </div>

        <div class="flex justify-between items-end mb-6">
            <div class="w-2/3">
                <table class="w-full text-left text-sm font-medium">
                    <tr>
                        <td class="py-1 w-32 text-gray-500 uppercase tracking-wider font-bold">Student Name:</td>
                        <td class="py-1 text-lg font-black uppercase border-b border-gray-300">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500 uppercase tracking-wider font-bold">Roll Number:</td>
                        <td class="py-1 text-lg font-bold border-b border-gray-300">{{ $student->studentProfile->roll_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500 uppercase tracking-wider font-bold">Exam Session:</td>
                        <td class="py-1 text-md font-bold border-b border-gray-300">{{ $exam->name }} ({{ $exam->academic_session }})</td>
                    </tr>
                </table>
            </div>
            
            <div class="text-center p-4 border-2 border-gray-900 rounded-lg bg-gray-50">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Final Grade</p>
                <p class="text-5xl font-black text-gray-900">{{ $grade }}</p>
            </div>
        </div>

        <div class="mb-8 border-2 border-gray-900 rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-900 text-white">
                    <tr>
                        <th class="p-3 text-sm font-bold uppercase tracking-wider border-r border-gray-700">Subject</th>
                        <th class="p-3 text-center text-sm font-bold uppercase tracking-wider border-r border-gray-700 w-24">Max Marks</th>
                        <th class="p-3 text-center text-sm font-bold uppercase tracking-wider border-r border-gray-700 w-28">Obtained</th>
                        <th class="p-3 text-left text-sm font-bold uppercase tracking-wider w-1/3">Teacher's Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($marks as $mark)
                        <tr class="border-b border-gray-300">
                            <td class="p-3 font-bold text-gray-900 border-r border-gray-300 uppercase">{{ $mark->subject->name }}</td>
                            <td class="p-3 text-center font-bold text-gray-600 border-r border-gray-300">{{ $mark->total_marks }}</td>
                            <td class="p-3 text-center font-black text-lg border-r border-gray-300 {{ $mark->is_absent ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $mark->is_absent ? 'ABSENT' : $mark->obtained_marks }}
                            </td>
                            <td class="p-3 text-sm text-gray-600 italic">{{ $mark->remarks ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500 font-bold">No marks have been recorded for this student yet.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($marks->count() > 0)
                    <tfoot class="bg-gray-100 border-t-2 border-gray-900">
                        <tr>
                            <td class="p-3 font-black text-right uppercase tracking-widest text-gray-900 border-r border-gray-300">Grand Total:</td>
                            <td class="p-3 text-center font-black text-xl text-gray-900 border-r border-gray-300">{{ $totalMaxMarks }}</td>
                            <td class="p-3 text-center font-black text-2xl text-gray-900 border-r border-gray-300">{{ $totalObtained }}</td>
                            <td class="p-3 text-center font-black text-lg text-indigo-700 bg-indigo-50">
                                {{ number_format($percentage, 2) }}%
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        <div class="mb-12 p-4 bg-gray-50 border border-gray-300 rounded-lg">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Principal / Headmaster Remarks</h3>
            <p class="text-lg font-medium text-gray-900 italic">"{{ $remarks }}"</p>
        </div>

        <div class="flex justify-between items-end pt-8">
            <div class="text-center w-48">
                <div class="border-t-2 border-gray-900"></div>
                <p class="text-xs font-bold text-gray-600 uppercase mt-2">Class Teacher</p>
            </div>
            
            <div class="text-center w-48">
                <div class="border-t-2 border-gray-900"></div>
                <p class="text-xs font-bold text-gray-600 uppercase mt-2">Parent / Guardian</p>
            </div>

            <div class="text-center w-48">
                <div class="border-t-2 border-gray-900"></div>
                <p class="text-xs font-bold text-gray-600 uppercase mt-2">Principal</p>
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400 font-medium">
            Generated by School Management System on {{ date('d M Y, h:i A') }}
        </div>

    </div>
</body>
</html>