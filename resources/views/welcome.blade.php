<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Martinis & Manicures Loyalty') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/martinis-icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/martinis-icon.png') }}">
    <meta name="theme-color" content="#A48D78">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <main class="min-h-screen px-4 py-8 sm:px-6">
        <div class="mx-auto flex min-h-[calc(100vh-4rem)] w-full max-w-5xl flex-col items-center justify-center gap-8 text-center">
            <img
                src="{{ asset('images/martinis-logo.png') }}"
                alt="Martinis and Manicures"
                class="h-auto w-64 max-w-full object-contain sm:w-80"
            >

            <div class="max-w-2xl space-y-4">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[var(--desert-rock)]">
                    Loyalty Management
                </p>
                <h1 class="text-3xl font-bold text-[var(--ink)] sm:text-5xl">
                    Martinis & Manicures Loyalty
                </h1>
                <p class="text-base leading-7 text-[var(--muted)] sm:text-lg">
                    Manage customers, loyalty cards, services, transactions, and QR scanning in one branded system.
                </p>
            </div>

            @if (Route::has('login'))
                <div class="flex flex-col items-center gap-3 sm:flex-row">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="theme-button">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="theme-button">
                            Sign In
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </main>
</body>
</html>
