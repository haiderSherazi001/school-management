<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daily Staff Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 shadow-sm">
                    <p class="text-sm font-bold text-green-800 flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Mark Attendance</h3>
                        <p class="text-sm text-gray-500">Select a date to view or update staff attendance.</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-bold text-gray-700">Date:</label>
                        <input type="date" wire:model.live="attendanceDate" max="{{ date('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-bold text-indigo-700">
                    </div>
                </div>

                <div class="p-0 overflow-x-auto">
                    <form wire:submit="saveAttendance">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Staff Member</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Present</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Late</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Half Day</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Absent</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Leave</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Remarks (Optional)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($staffMembers as $staff)
                                    <tr class="hover:bg-gray-50 transition">
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                                                    {{ substr($staff->name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $staff->name }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $staff->staffProfile->designation->title ?? 'Staff' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="radio" wire:model="attendanceData.{{ $staff->id }}" value="present" class="w-5 h-5 text-green-600 focus:ring-green-500 border-gray-300">
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="radio" wire:model="attendanceData.{{ $staff->id }}" value="late" class="w-5 h-5 text-yellow-500 focus:ring-yellow-500 border-gray-300">
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="radio" wire:model="attendanceData.{{ $staff->id }}" value="half_day" class="w-5 h-5 text-orange-500 focus:ring-orange-500 border-gray-300">
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="radio" wire:model="attendanceData.{{ $staff->id }}" value="absent" class="w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300">
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="radio" wire:model="attendanceData.{{ $staff->id }}" value="leave" class="w-5 h-5 text-blue-500 focus:ring-blue-500 border-gray-300">
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="text" wire:model="remarksData.{{ $staff->id }}" placeholder="e.g. Traffic / Sick" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 font-medium">
                                            No staff members found in the system.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end">
                            <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <span wire:loading.remove wire:target="saveAttendance">Save Attendance</span>
                                <span wire:loading wire:target="saveAttendance">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>