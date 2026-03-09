<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: $this->form->getRedirectRoute(), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-2">
            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span class="text-2xl font-bold text-gray-900 tracking-tight">EduFlow</span>
        </a>
        
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
            Sign in to your account
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Or
            <a href="{{ route('register') }}" wire:navigate class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                create a new account
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm border border-gray-200 sm:rounded-xl sm:px-10">
            
            <x-auth-session-status class="mb-6 text-sm font-medium text-green-700 bg-green-50 p-3 rounded-md border border-green-200" :status="session('status')" />

            <form wire:submit="login" class="space-y-6">
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <div class="mt-1">
                        <input wire:model="form.username" id="username" type="text" required autofocus
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors">
                    </div>
                    <x-input-error :messages="$errors->get('form.username')" class="mt-2 text-xs" />
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" wire:navigate class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="mt-1">
                        <input wire:model="form.password" id="password" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors">
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs" />
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer transition-colors">
                        <label for="remember" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                            Remember me
                        </label>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <span wire:loading.remove wire:target="login">Sign in</span>
                        <span wire:loading wire:target="login" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Authenticating...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>