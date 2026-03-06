<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Financial Ledger (Profit & Loss)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center bg-white p-4 shadow-sm sm:rounded-lg border border-gray-200">
                <h3 class="font-bold text-gray-800">Financial Overview for {{ $selectedYear }}</h3>
                <select wire:model.live="selectedYear" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold text-gray-700">
                    <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                    <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-start gap-4">
                    <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="w-full">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Revenue</p>
                        <p class="text-3xl font-black text-green-600 mt-1">Rs. {{ number_format($totalRevenue) }}</p>
                        
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100 w-full">
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Student Fees</p>
                                <p class="text-sm font-bold text-gray-700">Rs. {{ number_format($totalFeeRevenue) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] uppercase font-bold text-gray-400">Other Income</p>
                                <p class="text-sm font-bold text-gray-700">Rs. {{ number_format($totalGeneralIncome) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-start gap-4">
                    <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    </div>
                    <div class="w-full">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Expenses</p>
                        <p class="text-3xl font-black text-red-600 mt-1">Rs. {{ number_format($totalExpenses) }}</p>
                        
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100 w-full">
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Payroll</p>
                                <p class="text-sm font-bold text-gray-700">Rs. {{ number_format($totalPayroll) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] uppercase font-bold text-gray-400">Bills & Misc</p>
                                <p class="text-sm font-bold text-gray-700">Rs. {{ number_format($totalGeneralExpenses) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-start gap-4">
                    <div class="p-3 {{ $netProfit >= 0 ? 'bg-indigo-100 text-indigo-600' : 'bg-orange-100 text-orange-600' }} rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Net Profit</p>
                        <p class="text-3xl font-black {{ $netProfit >= 0 ? 'text-indigo-600' : 'text-orange-600' }} mt-1">
                            Rs. {{ number_format($netProfit) }}
                        </p>
                        <p class="text-xs {{ $netProfit >= 0 ? 'text-indigo-400' : 'text-orange-400' }} font-bold mt-2 uppercase tracking-wide">
                            {{ $netProfit >= 0 ? 'Surplus' : 'Deficit' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Monthly Breakdown</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Month</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Fees (In)</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Other (In)</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Payroll (Out)</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Bills (Out)</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase bg-gray-50">Net Result</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($monthlyData as $data)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $data['month_name'] }}</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-green-600 font-bold">
                                        {{ $data['fee_revenue'] > 0 ? 'Rs. ' . number_format($data['fee_revenue']) : '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-emerald-500 font-medium">
                                        {{ $data['general_income'] > 0 ? 'Rs. ' . number_format($data['general_income']) : '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-red-500 font-medium">
                                        {{ $data['payroll'] > 0 ? 'Rs. ' . number_format($data['payroll']) : '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-orange-500 font-medium">
                                        {{ $data['general_expense'] > 0 ? 'Rs. ' . number_format($data['general_expense']) : '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-black bg-gray-50/50 {{ $data['profit'] >= 0 ? 'text-indigo-600' : 'text-orange-600' }}">
                                        {{ $data['profit'] != 0 ? 'Rs. ' . number_format($data['profit']) : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>