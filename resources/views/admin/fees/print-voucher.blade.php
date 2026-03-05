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

                <div class="flex justify-between items-start border-b-2 border-gray-200 pb-4 mb-4">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">
                            {{ \App\Models\Setting::get('school_name', 'YOUR SCHOOL NAME') }}
                        </h2>
                        <p class="text-sm text-gray-500 font-medium">
                            {{ \App\Models\Setting::get('school_address', '123 Education Road, City Campus') }}
                        </p>
                        <p class="text-sm text-gray-500 font-medium">
                            Contact: {{ \App\Models\Setting::get('school_phone', '+92 000 0000000') }}
                        </p>
                        <p class="text-sm font-bold mt-2 px-2 py-0.5 bg-gray-200 inline-block rounded">{{ $copyType }}</p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-xl font-bold text-gray-900">FEE VOUCHER</h3>
                        <p class="text-sm text-gray-600 font-medium mt-1">Month: <span class="font-bold text-gray-900">{{ $voucher->billing_month }}</span></p>
                        <p class="text-sm text-gray-600 mt-1">Voucher No: <span class="font-mono text-gray-900">{{ $voucher->voucher_number }}</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 mb-6">
                    <div>
                        <table class="w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="py-1 text-gray-500 w-24">Student Name:</td>
                                    <td class="py-1 font-bold text-gray-900 border-b border-gray-300">{{ $voucher->student->name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-500 w-24">Guardian Name:</td>
                                    <td class="py-1 font-bold text-gray-900 border-b border-gray-300">{{ $voucher->student->studentProfile->guardian_name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-500">Roll No:</td>
                                    <td class="py-1 font-bold text-gray-900 border-b border-gray-300">{{ $voucher->student->studentProfile->roll_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-500">Class:</td>
                                    <td class="py-1 font-bold text-gray-900 border-b border-gray-300">{{ $voucher->class->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1 text-gray-500">Issue Date:</td>
                                    <td class="py-1 font-bold text-gray-900 border-b border-gray-300">{{ $voucher->created_at->format('d M, Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col justify-center items-end">
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 w-full text-right">
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Total Amount Due</p>
                            <p class="text-3xl font-black text-gray-900">Rs. {{ number_format($voucher->amount) }}</p>
                            
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-sm font-medium {{ $voucher->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                                    Due Date: {{ $voucher->due_date->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-end mt-12 pt-4">
                    <div class="text-center w-48">
                        <div class="border-t border-gray-400"></div>
                        <p class="text-xs text-gray-500 mt-1 mt-1">Bank / Cashier Signature</p>
                    </div>
                    <div class="text-center w-48">
                        <div class="border-t border-gray-400"></div>
                        <p class="text-xs text-gray-500 mt-1">Parent Signature</p>
                    </div>
                </div>
            </div>

            @if($loop->first)
                <div class="my-8 relative flex items-center justify-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-dashed border-gray-300"></div>
                    </div>
                    <div class="relative bg-white px-4 text-gray-400">
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