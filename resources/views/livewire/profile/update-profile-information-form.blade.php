<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="max-w-2xl">
    <header class="mb-8">
        <h2 class="text-xl font-black text-gray-900 tracking-tight">
            {{ __('Registry Information') }}
        </h2>

        <p class="mt-1 text-sm font-medium text-gray-500 uppercase tracking-widest text-[10px]">
            {{ __("Manage your identity and communication credentials.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-6">
        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1" for="name">Name</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </span>
                <input wire:model="name" id="name" name="name" type="text" required autofocus autocomplete="name"
                       class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm shadow-sm" />
            </div>
            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-tight" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1" for="email">System Email Address</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </span>
                <input wire:model="email" id="email" name="email" type="email" required autocomplete="username"
                       class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-gray-100 text-gray-900 font-bold rounded-2xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition sm:text-sm shadow-sm" />
            </div>
            <x-input-error class="mt-2 text-[10px] font-black uppercase tracking-tight" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                    <p class="text-xs font-bold text-amber-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button wire:click.prevent="sendVerification" class="mt-2 text-[10px] font-black uppercase tracking-widest text-amber-600 hover:text-amber-800 transition underline underline-offset-4">
                        {{ __('Re-send verification link') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 font-black text-[10px] text-emerald-600 uppercase tracking-widest">
                            {{ __('✓ A new link has been dispatched to your inbox.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gray-900 border border-transparent rounded-2xl font-black text-[10px] text-white uppercase tracking-widest hover:bg-indigo-600 focus:bg-indigo-600 active:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition ease-in-out duration-150 shadow-lg shadow-gray-200">
                {{ __('Update Profile') }}
            </button>

            <x-action-message class="text-[10px] font-black text-emerald-600 uppercase tracking-widest" on="profile-updated">
                {{ __('Registry Synchronized.') }}
            </x-action-message>
        </div>
    </form>
</section>