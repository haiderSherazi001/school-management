<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        // Assign default role if you have Spatie Roles set up
        // $user->assignRole('Admin'); 

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
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

    <div class="w-full max-w-xl bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

        <div class="mb-10 text-center sm:text-left">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Create Institution Account</h2>
            <p class="text-sm font-medium text-gray-400 mt-1 uppercase tracking-widest text-[10px]">Registry Onboarding Process</p>
        </div>

        <form wire:submit="register" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Administrator Name</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    <input wire:model="name" type="text" required autofocus placeholder="e.g. Haider" 
                           class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px] font-black uppercase" />
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">System ID</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                    </span>
                    <input wire:model="username" type="text" required placeholder="username" 
                           class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm" />
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-2 text-[10px] font-black uppercase" />
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Official Email</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </span>
                    <input wire:model="email" type="email" required placeholder="name@school.com" 
                           class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-black uppercase" />
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Security Key</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <input wire:model="password" type="password" required placeholder="••••••••"
                           class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm shadow-sm" />
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Verify Key</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </span>
                    <input wire:model="password_confirmation" type="password" required placeholder="••••••••"
                           class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm shadow-sm" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-black uppercase" />
            </div>

            <div class="md:col-span-2 pt-4">
                <button type="submit" class="w-full group inline-flex items-center justify-center bg-gray-900 hover:bg-indigo-600 text-white font-black py-4 px-8 rounded-2xl shadow-xl transition-all duration-300 active:scale-[0.98]">
                    <span class="uppercase tracking-[0.2em] text-xs">Initialize Registry Account</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                Already have an account? 
                <a href="{{ route('login') }}" wire:navigate class="text-indigo-600 hover:text-indigo-800 transition underline underline-offset-4 ml-1">Authorize here</a>
            </p>
        </div>
    </div>
</div>