<div class="py-12 bg-gray-50/50 min-h-screen" x-data x-on:livewire:navigated.window="$wire.$refresh()">
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 tracking-tight leading-tight">
            {{ __('Staff Attendance History') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <h3 class="text-lg font-black text-gray-900">{{ $monthLabel }}</h3>
                <p class="text-sm text-gray-500">Monthly attendance record for all active staff.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('hr.attendance') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-50 hover:bg-indigo-50 hover:text-indigo-700 text-sm font-bold text-gray-700 rounded-xl transition">
                    Mark Attendance
                </a>
                <label class="text-sm font-bold text-gray-700">Month:</label>
                <input type="month" wire:model.live="month" max="{{ now()->format('Y-m') }}" class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition sm:text-sm font-bold text-indigo-700">
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-xs font-bold text-gray-600">
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-500"></span> Present</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-yellow-500"></span> Late</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-orange-500"></span> Half Day</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500"></span> Absent</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Leave</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-gray-200"></span> No Record</span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto" wire:loading.class="opacity-50 pointer-events-none" wire:target="month">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="sticky left-0 bg-gray-50/50 px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest z-10">
                                Staff Member
                            </th>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th class="px-2 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ $day }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @php
                            $statusStyles = [
                                'present' => ['bg-green-500 text-white', 'P'],
                                'late' => ['bg-yellow-500 text-white', 'L'],
                                'half_day' => ['bg-orange-500 text-white', 'H'],
                                'absent' => ['bg-red-500 text-white', 'A'],
                                'leave' => ['bg-blue-500 text-white', 'Lv'],
                            ];
                            $emptyStyle = ['bg-gray-100 text-gray-400', '—'];
                        @endphp
                        @forelse ($staffMembers as $staff)
                            @php
                                $dayRecords = $attendanceMatrix->get($staff->id, collect());
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition" wire:key="staff-{{ $staff->id }}">
                                <td class="sticky left-0 bg-white px-6 py-3 whitespace-nowrap z-10">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                            {{ substr($staff->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-black text-gray-900">{{ $staff->name }}</div>
                                            <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $staff->staffProfile->designation->title ?? 'Staff' }}</div>
                                        </div>
                                    </div>
                                </td>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $record = $dayRecords->get($day);
                                        [$style, $label] = $record ? ($statusStyles[$record->status] ?? $emptyStyle) : $emptyStyle;
                                    @endphp
                                    <td class="px-2 py-3 text-center">
                                        <span title="{{ $record ? ucfirst(str_replace('_', ' ', $record->status)) . ($record->remarks ? ': '.$record->remarks : '') : 'No record' }}"
                                              class="inline-flex items-center justify-center w-6 h-6 rounded-full text-[9px] font-black {{ $style }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $daysInMonth + 1 }}" class="px-6 py-8 text-center text-gray-500 font-medium">
                                    No staff members found in the system.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
