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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6"
                 x-data="{ 
                     isEditing: @entangle('isEditing'),
                     class_id: @entangle('class_id'),
                     tuition_fee: @entangle('tuition_fee'),
                     
                     // This runs instantly in the browser!
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
                
                <div class="md:col-span-1" id="fee-form-container">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border transition-all duration-300 relative overflow-hidden"
                         :class="isEditing ? 'border-indigo-400 ring-4 ring-indigo-50 shadow-md' : 'border-gray-200'">
                        
                        <div x-show="isEditing" x-cloak class="absolute top-0 left-0 w-full h-1 bg-indigo-500 animate-pulse"></div>

                        <h3 class="text-lg font-medium mb-4 border-b pb-2 transition-colors duration-300" :class="isEditing ? 'text-indigo-700' : 'text-gray-900'">
                            <span x-text="isEditing ? '✏️ Update Class Fee' : 'Set Class Fee'"></span>
                        </h3>
                        
                        <form wire:submit="save">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Class</label>
                                <select wire:model="class_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        :disabled="isEditing"
                                        :class="isEditing ? 'bg-gray-100 cursor-not-allowed' : ''">
                                    <option value="">-- Choose a Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->name }} {{ $class->description ? '('.$class->description.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Tuition Fee (Rs.)</label>
                                <input type="number" wire:model="tuition_fee" placeholder="e.g. 3000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('tuition_fee') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-end gap-x-3 pt-4 border-t">
                                <button type="button" x-show="isEditing" x-cloak @click="cancelEdit()" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 mr-2">
                                    Cancel
                                </button>
                                
                                <button type="submit" wire:loading.attr="disabled" class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition w-full sm:w-auto">
                                    <span wire:loading.remove wire:target="save" x-text="isEditing ? 'Update Fee' : 'Save Fee'"></span>
                                    <span wire:loading wire:target="save">Processing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-4 bg-gray-50 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">
                                Current Session Active Fees
                            </span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Fee</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($this->feeStructures as $fee)
                                        <tr class="transition-colors hover:bg-gray-50" :class="(isEditing && class_id == {{ $fee->class_id }}) ? 'bg-indigo-50/50 ring-1 ring-inset ring-indigo-200' : ''">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $fee->academicClass->name }}
                                                @if($fee->academicClass->description)
                                                    <span class="text-gray-500 font-normal">({{ $fee->academicClass->description }})</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                                Rs. {{ number_format($fee->tuition_fee) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" @click="editFee({{ $fee->class_id }}, {{ $fee->tuition_fee }})" class="text-indigo-600 hover:text-indigo-900 font-semibold transition">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-gray-500 text-sm">
                                                <p>No fee structures defined for this session yet.</p>
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