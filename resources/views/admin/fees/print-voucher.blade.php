<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Voucher - {{ $voucher->voucher_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            @page { margin: 0; size: auto; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900" onload="window.print()">
    
    <div class="no-print bg-gray-800 text-white p-4 flex justify-between items-center shadow-md mb-8">
        <div>
            <h1 class="text-lg font-bold">Print Preview Mode</h1>
            <p class="text-sm text-gray-300">Press Ctrl+P or Cmd+P to print if the dialog didn't open automatically.</p>
        </div>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md font-semibold transition">
            Print Now
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-8 shadow-sm print:shadow-none print:p-4">
        
        @foreach(['School Copy', 'Student Copy'] as $copyType)
            
            <div class="border-2 border-gray-800 rounded-lg p-6 relative">
                
                @if($voucher->status === 'paid')
                    <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
                        <span class="text-8xl font-black text-green-600 uppercase tracking-widest transform -rotate-12 border-8 border-green-600 p-4 rounded-lg">PAID</span>
                    </div>
                @endif

                <div class="flex justify-between items-start border-b-2 border-gray-800 pb-4 mb-4">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">
                            {{ \App\Models\Setting::get('school_name', 'YOUR SCHOOL NAME') }}
                        </h2>
                        <p class="text-xs text-gray-500 font-medium mt-1">
                            {{ \App\Models\Setting::get('school_address', '123 Education Road, City Campus') }}<br>
                            Contact: {{ \App\Models\Setting::get('school_phone', '+92 000 0000000') }}
                        </p>
                        <p class="text-xs font-bold mt-2 px-2 py-1 bg-gray-800 text-white inline-block rounded uppercase tracking-wider">{{ $copyType }}</p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-xl font-bold text-gray-900">FEE VOUCHER</h3>
                        <p class="text-sm text-gray-600 font-medium mt-1">Month: <span class="font-bold text-gray-900">{{ $voucher->billing_month }}</span></p>
                        <p class="text-sm text-gray-600 mt-1">Voucher No: <span class="font-mono text-gray-900">{{ $voucher->voucher_number }}</span></p>
                        <p class="text-sm text-gray-600 mt-1">Issue Date: <span class="font-bold text-gray-900">{{ $voucher->created_at->format('d M, Y') }}</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-8 gap-y-2 mb-4 text-sm">
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500">Student Name:</span>
                        <span class="font-bold text-gray-900">{{ $voucher->student->name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500">Roll No:</span>
                        <span class="font-bold text-gray-900">{{ $voucher->student->studentProfile->roll_number ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500">Guardian Name:</span>
                        <span class="font-bold text-gray-900">{{ $voucher->student->studentProfile->guardian_name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500">Class:</span>
                        <span class="font-bold text-gray-900">{{ $voucher->class->name ?? 'N/A' }}</span>
                    </div>
                </div>

                <table class="w-full text-sm text-left border-collapse mt-4 mb-4">
                    <thead>
                        <tr class="bg-gray-100 border-y-2 border-gray-800">
                            <th class="py-2 px-3 font-bold text-gray-800 uppercase tracking-wider text-xs">Description / Particulars</th>
                            <th class="py-2 px-3 font-bold text-gray-800 uppercase tracking-wider text-xs text-right w-40">Amount (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($voucher->items as $item)
                            <tr class="border-b border-gray-200">
                                <td class="py-2 px-3 text-gray-800 font-medium">{{ $item->title }}</td>
                                <td class="py-2 px-3 text-gray-900 font-bold text-right">{{ number_format($item->amount) }}</td>
                            </tr>
                        @empty
                            <tr class="border-b border-gray-200">
                                <td class="py-2 px-3 text-gray-800 font-medium">Monthly Tuition Fee</td>
                                <td class="py-2 px-3 text-gray-900 font-bold text-right">{{ number_format($voucher->amount) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex justify-between items-start mt-2">
                    <div class="bg-gray-50 p-3 rounded border border-gray-200 w-1/2">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Important Notice</p>
                        <p class="text-xs text-gray-600">Please pay the dues before the deadline. Late payments may be subject to a fine in the next billing cycle.</p>
                        <p class="text-sm font-bold mt-2 {{ $voucher->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                            DUE DATE: {{ $voucher->due_date->format('d M, Y') }}
                        </p>
                    </div>
                    
                    <div class="text-right flex flex-col items-end">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Grand Total</p>
                        <p class="text-3xl font-black text-gray-900">Rs. {{ number_format($voucher->amount) }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-end mt-12 pt-4">
                    <div class="text-center w-48">
                        <div class="border-t border-gray-800"></div>
                        <p class="text-xs text-gray-600 mt-1 font-medium">Bank / Cashier Signature</p>
                    </div>
                    <div class="text-center w-48">
                        <div class="border-t border-gray-800"></div>
                        <p class="text-xs text-gray-600 mt-1 font-medium">Parent / Guardian Signature</p>
                    </div>
                </div>
            </div>

            @if($loop->first)
                <div class="my-6 relative flex items-center justify-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-dashed border-gray-400"></div>
                    </div>
                    <div class="relative bg-white px-4 text-gray-500 flex items-center gap-2">
                        <span class="text-xs uppercase tracking-widest font-bold">Tear Here</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 transform -rotate-90">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.81 2.378a.864.864 0 011.025-.224l5.362 2.682a2.25 2.25 0 011.006 1.155l.89 2.227h2.157c1.326 0 2.4.992 2.4 2.214v1.272c0 1.222-1.074 2.214-2.4 2.214H16.1l-1.353 3.385a2.25 2.25 0 01-1.006 1.155l-5.362 2.682a.864.864 0 01-1.024-.224l-3.37-3.37a2.25 2.25 0 01-.659-1.59V8.04c0-.597.237-1.17.659-1.59l3.37-3.37z" />
                        </svg>
                    </div>
                </div>
            @endif

        @endforeach

    </div>
</body>
</html>