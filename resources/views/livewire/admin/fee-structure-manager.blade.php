<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Fee Structures') }}
            </h2>
            <a href="{{ route('classes.index') ?? '#' }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                &larr; Back to Classes
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session()->has('success'))
                <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-500 shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="rounded-md bg-red-50 p-4 border-l-4 border-red-500 shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-gradient-to-r from-indigo-50 to-white border border-indigo-200 rounded-lg shadow-sm p-6">
                <div class="flex flex-col lg:flex-row items-center gap-6">
                    <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-full text-indigo-600 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                    </div>
                    <div class="flex-1 w-full">
                        <h3 class="text-lg font-bold text-indigo-900 mb-1">Session Rollover (Clone Fees)</h3>
                        <p class="text-sm text-indigo-700">Save time by copying an entire fee structure from an older academic session into a new one.</p>
                        
                        <div class="mt-4 flex flex-col sm:flex-row items-end gap-4">
                            <div class="w-full sm:w-1/3">
                                <label class="block text-xs font-bold text-indigo-800 uppercase tracking-wider mb-1">Copy From Session</label>
                                <input type="text" wire:model="cloneFromSession" placeholder="e.g., 2025-2026" class="w-full rounded-md border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div class="flex-shrink-0 text-indigo-400 hidden sm:block mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>

                            <div class="w-full sm:w-1/3">
                                <label class="block text-xs font-bold text-indigo-800 uppercase tracking-wider mb-1">To Target Session</label>
                                <input type="text" wire:model="cloneToSession" placeholder="e.g., 2026-2027" class="w-full rounded-md border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <button wire:click="cloneStructure" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 sm:py-2.5 px-6 rounded-md shadow-sm transition">
                                Clone Structure
                            </button>
                        </div>
                        
                        @error('cloneToSession') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                        @error('cloneFromSession') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6"
                 x-data="{ 
                     isEditing: @entangle('isEditing'),
                     class_id: @entangle('class_id'),
                     tuition_fee: @entangle('tuition_fee'),
                     
                     editFee(id, fee) {
                         this.class_id = id;
                         this.tuition_fee = fee;
                         this.isEditing = true;
                         setTimeout(() => {
                             document.getElementById('fee-form-container').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                         }, 50);
                     },
                     cancelEdit() {
                         this.isEditing = false;
                         this.class_id = '';
                         this.tuition_fee = '';
                     }
                 }">
                
                <div class="lg:col-span-1" id="fee-form-container">
                    <div class="bg-white p-6 rounded-lg shadow-sm border transition-all duration-300 relative overflow-hidden"
                         :class="isEditing ? 'border-indigo-400 ring-4 ring-indigo-50 shadow-md' : 'border-gray-200'">
                        
                        <div x-show="isEditing" x-cloak class="absolute top-0 left-0 w-full h-1 bg-indigo-500 animate-pulse"></div>

                        <h3 class="text-lg font-bold mb-4 border-b pb-2 transition-colors duration-300" :class="isEditing ? 'text-indigo-700' : 'text-gray-900'">
                            <span x-text="isEditing ? '✏️ Update Class Fee' : 'Set Class Fee'"></span>
                        </h3>
                        
                        <form wire:submit="save">
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Select Class</label>
                                <select wire:model="class_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium"
                                        :disabled="isEditing"
                                        :class="isEditing ? 'bg-gray-100 cursor-not-allowed text-gray-500' : ''">
                                    <option value="">-- Choose a Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->name }} {{ $class->description ? '('.$class->description.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Monthly Tuition Fee (Rs.)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rs.</span>
                                    </div>
                                    <input type="number" wire:model="tuition_fee" placeholder="3000" class="w-full rounded-md border-gray-300 pl-9 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                                </div>
                                @error('tuition_fee') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-end gap-x-3 pt-4 border-t border-gray-100">
                                <button type="button" x-show="isEditing" x-cloak @click="cancelEdit()" class="text-sm font-bold leading-6 text-gray-500 hover:text-gray-900 mr-2 transition">
                                    Cancel
                                </button>
                                
                                <button type="submit" wire:loading.attr="disabled" class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition w-full sm:w-auto">
                                    <span wire:loading.remove wire:target="save" x-text="isEditing ? 'Update Fee' : 'Save Fee'"></span>
                                    <span wire:loading wire:target="save">Processing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-gray-700">
                                Current Session Active Fees
                            </h3>
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2.5 py-0.5 rounded border border-indigo-200">
                                {{ $this->feeStructures->count() }} Configured
                            </span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Class</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Monthly Fee</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($this->feeStructures as $fee)
                                        <tr class="transition-colors hover:bg-gray-50" :class="(isEditing && class_id == {{ $fee->class_id }}) ? 'bg-indigo-50/50' : ''">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                {{ $fee->class->name }}
                                                @if($fee->class->description)
                                                    <span class="text-gray-500 font-medium ml-1">({{ $fee->class->description }})</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-black">
                                                Rs. {{ number_format($fee->tuition_fee) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" @click="editFee({{ $fee->class_id }}, {{ $fee->tuition_fee }})" class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-50 px-3 py-1 rounded-md hover:bg-indigo-100 transition">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-gray-500 text-sm">
                                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="font-medium">No fee structures defined for this session yet.</p>
                                                <p class="text-gray-400 mt-1">Use the form or the clone tool above to get started.</p>
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