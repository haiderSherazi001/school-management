<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Self-Service Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-4 text-center md:text-left flex-col md:flex-row">
                        <div class="h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-3xl font-bold border-2 border-indigo-200">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-500 font-medium">{{ $profile->designation->title ?? 'Staff Member' }} • {{ $user->username }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-100 text-center">
                            <p class="text-xs text-gray-400 font-bold uppercase">Base Salary</p>
                            <p class="text-lg font-bold text-gray-800">Rs. {{ number_format($profile->salary) }}</p>
                        </div>
                        <div class="bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100 text-center">
                            <p class="text-xs text-indigo-400 font-bold uppercase">Status</p>
                            <p class="text-lg font-bold text-indigo-700 capitalize">{{ $profile->employment_status }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        My Salary History
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Month</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Base</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Adjustments</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Net Payable</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($payslips as $slip)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($slip->billing_month)->format('F Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        Rs. {{ number_format($slip->base_salary) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        @if($slip->bonuses > 0) <span class="text-green-600 font-bold">+{{ number_format($slip->bonuses) }}</span> @endif
                                        @if($slip->deductions > 0) <span class="text-red-600 font-bold">-{{ number_format($slip->deductions) }}</span> @endif
                                        @if(!$slip->bonuses && !$slip->deductions) <span class="text-gray-400">None</span> @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-900">
                                        Rs. {{ number_format($slip->net_payable) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($slip->status === 'paid')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paid on {{ $slip->paid_at->format('d M') }}</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Processing</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">No salary records found yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>