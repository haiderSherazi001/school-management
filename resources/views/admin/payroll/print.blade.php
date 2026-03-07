<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - {{ $payslip->staff->name }} - {{ $payslip->billing_month }}</title>
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
        
        @foreach(['Office Copy', 'Employee Copy'] as $copyType)
            
            <div class="border-2 border-gray-800 rounded-lg p-6 relative">
                
                @if($payslip->status === 'paid')
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
                        <h3 class="text-2xl font-black text-gray-900">SALARY SLIP</h3>
                        <p class="text-sm text-gray-600 font-medium mt-1">Salary Month: <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($payslip->billing_month)->format('F Y') }}</span></p>
                        <p class="text-sm text-gray-600 mt-1">Issue Date: <span class="font-bold text-gray-900">{{ $payslip->created_at->format('d M, Y') }}</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-8 gap-y-2 mb-6 text-sm bg-gray-50 p-4 border border-gray-200 rounded-md">
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500 font-bold">Employee Name:</span>
                        <span class="font-bold text-gray-900 uppercase">{{ $payslip->staff->name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500 font-bold">Designation:</span>
                        <span class="font-bold text-gray-900">{{ $payslip->staff->staffProfile->designation->title ?? 'Staff' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500 font-bold">Employee ID:</span>
                        <span class="font-bold text-gray-900">EMP-{{ str_pad($payslip->staff->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-gray-500 font-bold">Department:</span>
                        <span class="font-bold text-gray-900">{{ $payslip->staff->staffProfile->designation->department ?? 'General' }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-0 border-2 border-gray-800 mb-4 text-sm">
                    <div class="border-r-2 border-gray-800">
                        <div class="bg-gray-100 p-2 border-b-2 border-gray-800 text-center font-black uppercase tracking-wider">Earnings</div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-700 font-medium">Basic Salary</span>
                                <span class="font-bold text-gray-900">Rs. {{ number_format($payslip->base_salary) }}</span>
                            </div>
                            @if($payslip->bonuses > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-700 font-medium">Bonuses / Allowances</span>
                                <span class="font-bold text-gray-900">Rs. {{ number_format($payslip->bonuses) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <div class="bg-gray-100 p-2 border-b-2 border-gray-800 text-center font-black uppercase tracking-wider">Deductions</div>
                        <div class="p-4 space-y-3">
                            @if($payslip->deductions > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-700 font-medium">Absences / Penalties</span>
                                <span class="font-bold text-red-600">- Rs. {{ number_format($payslip->deductions) }}</span>
                            </div>
                            @else
                            <div class="text-center text-gray-400 italic mt-2">No deductions</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center mt-2">
                    <div class="bg-gray-800 text-white p-3 rounded flex items-center gap-4 w-1/2 justify-between">
                        <span class="font-bold uppercase tracking-widest text-sm">Net Payable Amount</span>
                        <span class="text-2xl font-black">Rs. {{ number_format($payslip->net_payable) }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mt-16 pt-4">
                    <div class="text-center w-48">
                        <div class="border-t border-gray-800"></div>
                        <p class="text-xs text-gray-600 mt-1 font-bold uppercase">Authorized Signatory</p>
                    </div>
                    <div class="text-center w-48">
                        <div class="border-t border-gray-800"></div>
                        <p class="text-xs text-gray-600 mt-1 font-bold uppercase">Employee Signature</p>
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