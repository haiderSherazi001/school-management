<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academics: Manage Exams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 shadow-sm flex items-start">
                    <svg class="h-5 w-5 text-green-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">
                
                <div class="w-full md:w-1/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-900">{{ $isEditing ? 'Edit Exam' : 'Create New Exam' }}</h3>
                        </div>
                        <div class="p-6">
                            <form wire:submit="saveExam" class="space-y-4">
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Exam Name</label>
                                    <input type="text" wire:model="name" placeholder="e.g. Mid-Term 2026" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Academic Session</label>
                                    <input type="text" wire:model="academic_session" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50" readonly>
                                    <p class="text-xs text-gray-500 mt-1">Auto-filled from Global Settings.</p>
                                    @error('academic_session') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Start Date</label>
                                    <input type="date" wire:model="start_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('start_date') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="pt-2 flex gap-2">
                                    @if($isEditing)
                                        <button type="button" wire:click="resetForm" class="flex-1 bg-white border border-gray-300 rounded-md py-2 px-4 text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition shadow-sm">
                                            Cancel
                                        </button>
                                    @endif
                                    <button type="submit" wire:loading.attr="disabled" class="flex-1 bg-indigo-600 border border-transparent rounded-md py-2 px-4 text-sm font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                                        <span wire:loading.remove wire:target="saveExam">{{ $isEditing ? 'Update Exam' : 'Create Exam' }}</span>
                                        <span wire:loading wire:target="saveExam">Saving...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-0 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Exam Details</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Session</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Start Date</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($exams as $exam)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $exam->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $exam->academic_session }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                                {{ \Carbon\Carbon::parse($exam->start_date)->format('d M, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                                <button wire:click="editExam({{ $exam->id }})" class="text-indigo-600 hover:text-indigo-900 transition">Edit</button>
                                                <button wire:click="deleteExam({{ $exam->id }})" wire:confirm="Are you sure you want to delete this Exam? This will delete all associated marks!" class="text-red-600 hover:text-red-900 transition">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">
                                                No exams created yet. Use the form to create your first one.
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
</div>