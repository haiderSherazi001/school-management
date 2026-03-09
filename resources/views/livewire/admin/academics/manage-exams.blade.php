<div class="py-12 bg-gray-50/50 min-h-screen"> {{-- ONE ROOT ELEMENT --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-900 mb-2 transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transform group-hover:-translate-x-1 transition"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" /></svg>
                    Back to Dashboard
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Examination Management') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-200 shadow-sm flex items-start">
                <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold text-emerald-800 flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-8 transition-all duration-300 {{ $isEditing ? 'border-indigo-300 ring-4 ring-indigo-50 shadow-lg' : '' }}">
                    <div class="px-6 py-4 border-b border-gray-50 {{ $isEditing ? 'bg-indigo-50/30' : 'bg-gray-50/30' }}">
                        <h3 class="text-sm font-black uppercase tracking-widest {{ $isEditing ? 'text-indigo-700' : 'text-gray-900' }}">
                            {{ $isEditing ? 'Edit Exam Record' : 'Register New Exam' }}
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <form wire:submit="saveExam" class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Official Exam Name</label>
                                <input type="text" wire:model="name" placeholder="e.g. Annual Term 2026" class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-bold text-gray-900">
                                @error('name') <span class="text-red-500 text-[10px] font-black mt-1 block uppercase">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Assigned Session</label>
                                <div class="relative">
                                    <input type="text" wire:model="academic_session" readonly class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-400 font-black sm:text-sm cursor-not-allowed pr-10">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                    </div>
                                </div>
                                <p class="text-[9px] text-gray-400 font-bold mt-1.5 italic uppercase tracking-tighter">Matches Active System Session</p>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Start Date</label>
                                <input type="date" wire:model="start_date" class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm font-medium">
                                @error('start_date') <span class="text-red-500 text-[10px] font-black mt-1 block uppercase">{{ $message }}</span> @enderror
                            </div>

                            <div class="pt-4 border-t border-gray-50 flex items-center justify-end gap-3">
                                @if($isEditing)
                                    <button type="button" wire:click="resetForm" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition">Cancel</button>
                                @endif
                                
                                <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md shadow-indigo-100 transition uppercase tracking-widest text-xs">
                                    <span wire:loading.remove wire:target="saveExam">{{ $isEditing ? 'Update Exam' : 'Create Exam' }}</span>
                                    <span wire:loading wire:target="saveExam" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-5 bg-gray-50/50 border-b border-gray-100">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Exam Directory</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr class="text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="px-8 py-4">Examination Context</th>
                                    <th class="px-8 py-4">System Session</th>
                                    <th class="px-8 py-4">Scheduled Start</th>
                                    <th class="px-8 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($exams as $exam)
                                    <tr class="hover:bg-indigo-50/20 transition group" wire:key="exam-{{ $exam->id }}">
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <div class="text-sm font-black text-gray-900 group-hover:text-indigo-600 transition">{{ $exam->name }}</div>
                                            <div class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Registry ID: EXM-{{ $exam->id }}</div>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-blue-700 uppercase border border-blue-100 tracking-wider">
                                                {{ $exam->academic_session }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <div class="text-sm font-black text-gray-700">
                                                {{ \Carbon\Carbon::parse($exam->start_date)->format('d M, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap text-right font-bold space-x-3">
                                            <button wire:click="editExam({{ $exam->id }})" class="text-indigo-600 hover:text-indigo-900 text-xs uppercase tracking-widest">Edit</button>
                                            <button wire:click="deleteExam({{ $exam->id }})" wire:confirm="Wipe this exam and all student marks?" class="text-red-400 hover:text-red-700 text-xs uppercase tracking-widest">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="p-4 rounded-full bg-gray-50 text-gray-300 mb-4">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </div>
                                                <p class="text-sm font-black text-gray-400 uppercase tracking-widest">No active exams recorded</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>