<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-bold shadow-sm">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Welcome, {{ $user->name }}!</h3>
                            <p class="text-sm font-medium text-gray-500">Roll Number: <span class="text-indigo-600">{{ $profile->roll_number ?? $user->username }}</span></p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100 text-center min-w-[150px]">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Current Class</p>
                        <p class="text-xl font-black text-indigo-700">
                            {{ $currentEnrollment ? $currentEnrollment->class->name : 'Not Enrolled' }}
                        </p>
                    </div>
                </div>
            </div>

            @if($pendingFees->count() > 0)
                <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-sm p-6">
                    <div class="flex items-start gap-4">
                        <div class="bg-red-100 p-2 rounded-full mt-1">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-red-800 mb-1">Pending Fee Vouchers</h3>
                            <p class="text-sm text-red-700 mb-4">You have {{ $pendingFees->count() }} unpaid fee voucher(s). Please clear your dues at the administrative office.</p>
                            
                            <div class="bg-white rounded border border-red-200 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Month</th>
                                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Due Date</th>
                                            <th class="px-4 py-2 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($pendingFees as $fee)
                                            <tr>
                                                <td class="px-4 py-3 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($fee->billing_month)->format('F Y') }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-600">
                                                    @if(\Carbon\Carbon::parse($fee->due_date)->isPast())
                                                        <span class="text-red-600 font-bold">{{ \Carbon\Carbon::parse($fee->due_date)->format('d M, Y') }} (Overdue)</span>
                                                    @else
                                                        {{ \Carbon\Carbon::parse($fee->due_date)->format('d M, Y') }}
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm font-black text-gray-900 text-right">Rs. {{ number_format($fee->amount) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-green-50 border border-green-200 rounded-lg shadow-sm p-6 flex items-center gap-4">
                    <div class="bg-green-100 p-2 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-green-800">No Pending Dues</h3>
                        <p class="text-sm text-green-700">All your fee vouchers are cleared for the current session. Thank you!</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>