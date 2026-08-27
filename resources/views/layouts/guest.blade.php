<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Martinis & Manicures Loyalty') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/martinis-icon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/martinis-icon.png') }}">
        <meta name="theme-color" content="#A48D78">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[var(--ink)] antialiased">
        <div class="flex min-h-screen items-center justify-center px-4 py-8">
            <div class="theme-card w-full max-w-[448px] overflow-hidden px-8 py-10 sm:px-12">
                <a href="/">
                    <img
                        src="{{ asset('images/martinis-logo.png') }}"
                        alt="Martinis and Manicures"
                        class="mx-auto h-auto w-72 max-w-full object-contain"
                    >
                </a>

                <div class="mt-8">
                    {{ $slot }}
                </div>

                <p class="mt-7 text-center text-xs font-bold text-[var(--muted)]">
                    Martinis &amp; Manicures &copy; {{ now()->year }}
                </p>
            </div>
        </div>
    </body>
</html>
