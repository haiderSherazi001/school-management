<div>
    @if($successMessage)
        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6 text-center animate-fade-in-down">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 mb-4">
                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Message Received!</h3>
            <p class="text-sm font-medium text-gray-600">Thank you for reaching out. Our sales team will review your requirements and get back to you shortly.</p>
            <button wire:click="$set('successMessage', false)" class="mt-4 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Send another message</button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('name') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" wire:model="email" id="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('email') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div>
                <label for="institution" class="block text-sm font-medium text-gray-700">Institution Name</label>
                <input type="text" wire:model="institution" id="institution" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('institution') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">How can we help?</label>
                <textarea id="message" wire:model="message" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                @error('message') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="submit">Send Request</span>
                <span wire:loading wire:target="submit">Sending...</span>
            </button>
        </form>
    @endif
</div>
