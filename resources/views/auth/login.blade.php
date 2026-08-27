<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-semibold tracking-[0.06em] text-[var(--desert-rock)]">
            Welcome Back
        </h1>
        <p class="mt-3 text-sm font-bold text-[var(--muted)]">
            Management System
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-2 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-[var(--desert-rock)]/35 text-[var(--desert-rock)] shadow-sm focus:ring-[var(--desert-rock)]" name="remember">
                <span class="ms-2 text-sm font-medium text-[var(--muted)]">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="rounded-md text-sm font-bold text-[var(--desert-rock)] hover:text-[var(--ink)] focus:outline-none focus:ring-2 focus:ring-[var(--desert-rock)] focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full">
            {{ __('Sign In') }}
        </x-primary-button>
    </form>
</x-guest-layout>
