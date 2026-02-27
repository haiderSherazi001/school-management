<div> <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h3>
                <p class="mt-2 text-gray-600">You are now successfully logged into the Staff Portal.</p>
            </div>
        </div>
    </div>
</div>