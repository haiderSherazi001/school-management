<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    #[On('avatar-updated')]
    public function refreshAvatar(){
        Auth::user()->refresh();
    }
    
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2 group">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-md shadow-indigo-100 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-lg font-black tracking-tighter text-gray-900">Edu<span class="text-indigo-600">Flow</span></span>
                    </a>
                </div>

                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        @role('Admin')
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            
                            <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')" wire:navigate>
                                {{ __('Students') }}
                            </x-nav-link>
                            
                            <x-nav-link :href="route('staff.index')" :active="request()->routeIs('staff.*')" wire:navigate>
                                {{ __('Staff') }}
                            </x-nav-link>
                            
                            <x-nav-link :href="route('classes.index')" :active="request()->routeIs('classes.*')" wire:navigate>
                                {{ __('Classes') }}
                            </x-nav-link>

                            <x-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')" wire:navigate>
                                {{ __('Settings') }}
                            </x-nav-link>
                        @endrole

                        @role('Staff')
                            <x-nav-link :href="route('staff.portal')" :active="request()->routeIs('staff.portal')" wire:navigate>
                                {{ __('Staff Portal') }}
                            </x-nav-link>
                        @endrole

                        @role('Student')
                            <x-nav-link :href="route('student.portal')" :active="request()->routeIs('student.portal')" wire:navigate>
                                {{ __('Student Portal') }}
                            </x-nav-link>
                        @endrole
                    </div>
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-xl text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-3 border border-gray-50 shadow-sm hover:shadow-md">
                                
                                @if(Auth::user()->avatar_path)
                                    <img class="h-8 w-8 rounded-full object-cover border-2 border-indigo-50" src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-700 font-black text-xs border border-indigo-100">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif

                                <div class="max-w-[100px] truncate">{{ Auth::user()->name }}</div>

                                <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-gray-50">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Account</p>
                            </div>
                            <x-dropdown-link :href="route('profile')" wire:navigate class="font-bold">
                                {{ __('My Profile') }}
                            </x-dropdown-link>

                            <button wire:click="logout" class="w-full text-start border-t border-gray-50">
                                <x-dropdown-link class="text-red-600 font-bold">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" wire:navigate class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" wire:navigate class="bg-gray-900 text-white px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg shadow-gray-200">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100 animate-fade-in">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @role('Admin')
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')" wire:navigate>
                        {{ __('Students') }}
                    </x-responsive-nav-link>
                @endrole
            @else
                <x-responsive-nav-link :href="route('login')" wire:navigate>
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" wire:navigate class="text-indigo-600 font-bold">
                    {{ __('Register Account') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-100 bg-gray-50/50">
                <div class="px-4 flex items-center gap-3">
                    @if(Auth::user()->avatar_path)
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="{{ Auth::user()->name }}" />
                    @else
                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif

                    <div>
                        <div class="font-bold text-base text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-xs text-gray-500 truncate max-w-[200px]">{{ Auth::user()->email ?? Auth::user()->username }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate class="font-bold">
                        {{ __('Profile Settings') }}
                    </x-responsive-nav-link>

                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link class="text-red-600 font-bold">
                            {{ __('Sign Out') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
        @endauth
    </div>
</nav>