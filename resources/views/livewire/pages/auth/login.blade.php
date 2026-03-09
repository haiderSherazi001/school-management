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

<div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 bg-white selection:bg-indigo-100">
    <div class="mb-10 flex flex-col items-center gap-4 animate-fade-in">
        <a href="/" wire:navigate class="flex items-center gap-3 group">
            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-200 group-hover:scale-105 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span class="text-3xl font-black tracking-tighter text-gray-900 italic">Edu<span class="text-indigo-600">Flow</span></span>
        </a>
    </div>

    <div class="w-full max-w-md bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

        <div class="mb-8">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Welcome Back</h2>
            <p class="text-sm font-medium text-gray-400 mt-1 uppercase tracking-widest">Access your workstation</p>
        </div>

        <x-auth-session-status class="mb-6 text-sm font-bold text-emerald-600 bg-emerald-50 p-3 rounded-xl border border-emerald-100" :status="session('status')" />

        <form wire:submit="login" class="space-y-6">
            <div>
                <label for="username" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Credential ID</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    <input wire:model="form.username" id="username" type="text" name="username" required autofocus placeholder="Enter username" 
                           class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm shadow-sm" />
                </div>
                <x-input-error :messages="$errors->get('form.username')" class="mt-2 text-[10px] font-black uppercase tracking-tight" />
            </div>

            <div>
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Security Key</label>
                    @if (Route::has('password.request'))
                        <a class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest transition" href="{{ route('password.request') }}" wire:navigate>
                            Forgot?
                        </a>
                    @endif
                </div>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <input wire:model="form.password" id="password" type="password" name="password" required placeholder="••••••••"
                           class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm shadow-sm" />
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-[10px] font-black uppercase tracking-tight" />
            </div>

            <div class="flex items-center">
                <label for="remember" class="inline-flex items-center cursor-pointer group">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-md border-gray-200 text-indigo-600 shadow-sm focus:ring-indigo-500 transition cursor-pointer" name="remember">
                    <span class="ms-3 text-xs font-black text-gray-400 group-hover:text-gray-600 uppercase tracking-widest transition">{{ __('Keep me synced') }}</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full relative group inline-flex items-center justify-center bg-gray-900 hover:bg-indigo-600 text-white font-black py-4 px-8 rounded-2xl shadow-xl shadow-gray-200 hover:shadow-indigo-100 transition-all duration-300 active:scale-[0.98]">
                    <span class="uppercase tracking-[0.2em] text-xs">Login</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <p class="mt-10 text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">
        &copy; {{ date('Y') }} EduFlow Encryption Systems
    </p>
</div>