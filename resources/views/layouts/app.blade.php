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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="antialiased overflow-x-hidden">

<div
    x-data="{ sidebarOpen: false }"
    class="min-h-screen"
>

    {{-- ========================================================= --}}
    {{-- MOBILE OVERLAY --}}
    {{-- ========================================================= --}}

    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black/30 lg:hidden"
        style="display: none;">
    </div>


    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}

    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="sidebar fixed inset-y-0 left-0 z-50
               w-64
               border-r border-[var(--desert-rock)]/25
               transition-transform duration-300
               shadow-2xl
               lg:translate-x-0"
    >

        <div class="flex h-full flex-col">


            {{-- ================================================= --}}
            {{-- BRAND --}}
            {{-- ================================================= --}}

            <div
                class="p-5"
            >

                <a
                    href="{{ Auth::user()->isStaff() ? route('scanner.index') : route('dashboard') }}"
                    class="flex min-h-20 items-center justify-center rounded-2xl border border-[var(--desert-rock)]/15 bg-[var(--feather-white)]/70 px-3 py-3 text-center shadow-sm"
                >
                    <img
                        src="{{ asset('images/martinis-logo.png') }}"
                        alt="Martinis and Manicures"
                        class="h-auto max-h-16 w-full max-w-[11rem] object-contain sm:max-h-20"
                    >
                </a>

            </div>


            {{-- ================================================= --}}
            {{-- NAVIGATION --}}
            {{-- ================================================= --}}

            @php
                $sidebarIcon = function (string $name): string {
                    $icons = [
                        'dashboard' => '<path d="M3 13h8V3H3v10Z"/><path d="M13 21h8V11h-8v10Z"/><path d="M3 21h8v-6H3v6Z"/><path d="M13 3v6h8V3h-8Z"/>',
                        'services' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.5-3.5a6 6 0 0 1-7.9 7.9l-6.6 6.6a2.1 2.1 0 0 1-3-3l6.6-6.6a6 6 0 0 1 7.9-7.9l-3.5 3.5Z"/>',
                        'plans' => '<path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/><path d="M12 7H7.5A2.5 2.5 0 1 1 12 5.5V7Z"/><path d="M12 7h4.5A2.5 2.5 0 1 0 12 5.5V7Z"/>',
                        'customers' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                        'memberships' => '<rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/><path d="M6 15h4"/><path d="M14 15h2"/>',
                        'transactions' => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z"/><path d="M8 7h8"/><path d="M8 12h8"/><path d="M8 17h5"/>',
                        'scanner' => '<path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><path d="M7 7h3v3H7z"/><path d="M14 7h3v3h-3z"/><path d="M7 14h3v3H7z"/><path d="M14 14h1"/><path d="M17 14h1"/><path d="M14 17h4"/>',
                        'users' => '<path d="M18 21a6 6 0 0 0-12 0"/><circle cx="12" cy="11" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/>',
                    ];

                    return '<svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $icons[$name] . '</svg>';
                };
            @endphp

            <nav
                class="flex-1 overflow-y-auto overflow-x-hidden px-5 py-3 space-y-2 [scrollbar-width:thin] [scrollbar-color:rgba(164,141,120,.45)_transparent]"
            >


                {{-- ================================================= --}}
                {{-- ADMIN + MANAGEMENT --}}
                {{-- ================================================= --}}

                @if(Auth::user()->hasRole('admin', 'management'))


                    {{-- DASHBOARD --}}

                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3
                               rounded-lg
                               px-4 py-3
                                   text-sm font-semibold
                                   transition

                        {{ request()->routeIs('dashboard')
                            ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
                            : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
                    >

                        {!! $sidebarIcon('dashboard') !!}

                        <span>
                            Dashboard
                        </span>

                    </a>


                    {{-- ================================================= --}}
                    {{-- MANAGEMENT TITLE --}}
                    {{-- ================================================= --}}

                    <div class="pt-5 pb-2 px-4">

                        <p
                            class="text-[10px]
                                   uppercase
                                   tracking-[0.2em]
                                   text-[var(--muted)]"
                        >
                            Management
                        </p>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SERVICES --}}
                    {{-- ================================================= --}}

                    <a
                        href="{{ route('services.index') }}"
                        class="flex items-center gap-3
                               rounded-lg
                               px-4 py-3
                               text-sm font-semibold
                               transition

                        {{ request()->routeIs('services.*')
                            ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
                            : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
                    >

                        {!! $sidebarIcon('services') !!}

                        <span>
                            Services
                        </span>

                    </a>


                    {{-- ================================================= --}}
                    {{-- LOYALTY PLANS --}}
                    {{-- ================================================= --}}

                    <a
                        href="{{ route('loyalty-plans.index') }}"
                        class="flex items-center gap-3
                               rounded-lg
                               px-4 py-3
                               text-sm font-semibold
                               transition

                        {{ request()->routeIs('loyalty-plans.*')
                            ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
                            : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
                    >

                        {!! $sidebarIcon('plans') !!}

                        <span>
                            Loyalty Plans
                        </span>

                    </a>


                    {{-- ================================================= --}}
                    {{-- CUSTOMERS --}}
                    {{-- ================================================= --}}

                    <a
                        href="{{ route('customers.index') }}"
                        class="flex items-center gap-3
                               rounded-lg
                               px-4 py-3
                               text-sm font-semibold
                               transition

                        {{ request()->routeIs('customers.*')
                            ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
                            : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
                    >

                        {!! $sidebarIcon('customers') !!}

                        <span>
                            Customers
                        </span>

                    </a>


                    <a
    href="{{ route('memberships.index') }}"
    class="flex items-center gap-3
           rounded-lg px-4 py-3
           text-sm font-semibold transition

    {{ request()->routeIs('memberships.*')
        ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
        : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
>

    {!! $sidebarIcon('memberships') !!}

    <span>
        Memberships
    </span>

</a>


                    {{-- ================================================= --}}
                    {{-- TRANSACTIONS --}}
                    {{-- ================================================= --}}

                    <a
                        href="{{ route('transactions.index') }}"
                        class="flex items-center gap-3
                               rounded-lg
                               px-4 py-3
                               text-sm font-semibold
                               transition

                        {{ request()->routeIs('transactions.*')
                            ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
                            : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
                    >

                        {!! $sidebarIcon('transactions') !!}

                        <span>
                            Transactions
                        </span>

                    </a>

                @endif


                {{-- ================================================= --}}
                {{-- QR SCANNER --}}
                {{-- AVAILABLE TO ADMIN + MANAGEMENT + STAFF --}}
                {{-- ================================================= --}}

                @if(Auth::user()->hasRole('admin', 'management'))

                    <div class="pt-5 pb-2 px-4">

                        <p
                            class="text-[10px]
                                   uppercase
                                   tracking-[0.2em]
                                   text-[var(--muted)]"
                        >
                            Loyalty
                        </p>

                    </div>

                @endif


                @if(Auth::user()->isStaff())

                    <div class="pb-2 px-4">

                        <p
                            class="text-[10px]
                                   uppercase
                                   tracking-[0.2em]
                                   text-[var(--muted)]"
                        >
                            Staff
                        </p>

                    </div>

                @endif


                <a
                    href="{{ route('scanner.index') }}"
                    class="flex items-center gap-3
                           rounded-lg
                           px-4 py-3
                           text-sm font-semibold
                           transition

                    {{ request()->routeIs('scanner.*')
                        ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
                        : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
                >

                    {!! $sidebarIcon('scanner') !!}

                    <span>
                        QR Scanner
                    </span>

                </a>


                {{-- ================================================= --}}
                {{-- ADMIN ONLY --}}
                {{-- ================================================= --}}

                @if(Auth::user()->isAdmin())

                    <div class="pt-5 pb-2 px-4">

                        <p
                            class="text-[10px]
                                   uppercase
                                   tracking-[0.2em]
                                   text-[var(--muted)]"
                        >
                            Administration
                        </p>

                    </div>


                    <a
    href="{{ route('users.index') }}"
    class="flex items-center gap-3
           rounded-lg px-4 py-3
           text-sm font-semibold transition

    {{ request()->routeIs('users.*')
        ? 'border border-[var(--desert-rock)] bg-[var(--desert-rock)] text-[var(--feather-white)] shadow-lg shadow-[#a48d78]/25'
        : 'border border-transparent text-[var(--ink)] hover:border-[var(--desert-rock)]/20 hover:bg-[var(--feather-white)]/65 hover:text-[var(--desert-rock)]' }}"
>

    {!! $sidebarIcon('users') !!}

    <span>
        User Management
    </span>

</a>

                @endif


            </nav>


            {{-- ========================================================= --}}
            {{-- USER INFORMATION --}}
            {{-- ========================================================= --}}

            <div
                class="p-5"
            >

                <div class="rounded-2xl border border-[var(--desert-rock)]/18 bg-[var(--feather-white)]/70 p-4 text-xs text-[var(--muted)] shadow-sm">


                    {{-- USER NAME --}}

                    <p
                        class="text-sm
                               font-medium
                               text-[var(--ink)]"
                    >
                        {{ Auth::user()->name }}
                    </p>


                    {{-- ROLE --}}

                    <div class="mt-1">

                        @if(Auth::user()->isAdmin())

                            <span
                                class="inline-flex
                                       rounded-full
                                       bg-[var(--creamed-oat)]
                                       px-2 py-1
                                       text-[9px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.15em]
                                       text-[var(--ink)]"
                            >
                                Admin
                            </span>

                        @elseif(Auth::user()->isManagement())

                            <span
                                class="inline-flex
                                       rounded-full
                                       bg-[var(--creamed-oat)]
                                       px-2 py-1
                                       text-[9px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.15em]
                                       text-[var(--ink)]"
                            >
                                Management
                            </span>

                        @else

                            <span
                                class="inline-flex
                                       rounded-full
                                       bg-[var(--creamed-oat)]
                                       px-2 py-1
                                       text-[9px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.15em]
                                       text-[var(--ink)]"
                            >
                                Staff
                            </span>

                        @endif

                    </div>


                    {{-- EMAIL --}}

                    <p
                        class="text-xs
                               text-[var(--muted)]
                               truncate
                               mt-2"
                    >
                        {{ Auth::user()->email }}
                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- LOGOUT --}}
                {{-- ================================================= --}}

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full
                               text-left
                               rounded-xl
                               border border-red-200/80
                               bg-red-50
                               px-4 py-3
                               text-sm
                               font-bold
                               text-red-700
                               hover:bg-red-100
                               transition"
                    >

                        Log Out

                    </button>

                </form>

            </div>

        </div>

    </aside>


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <div class="lg:pl-64">


        {{-- ===================================================== --}}
        {{-- TOP BAR --}}
        {{-- ===================================================== --}}

        <header
            class="glass sticky top-0 z-30
                   h-16
                   border-b border-[var(--desert-rock)]/20
                   backdrop-blur"
        >

            <div
                class="h-full
                       flex items-center justify-between
                       px-4 sm:px-6 lg:px-8"
            >


                {{-- MOBILE MENU BUTTON --}}

                <button
                    @click="sidebarOpen = true"
                    class="lg:hidden
                           p-2
                           rounded-lg
                           text-[#493B32]
                           hover:bg-[#E6DAC8]"
                    aria-label="Open sidebar"
                >

                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M4 7h16"/>
                        <path d="M4 12h16"/>
                        <path d="M4 17h16"/>
                    </svg>

                </button>


                {{-- DESKTOP LABEL --}}

                <div
                    class="hidden lg:block
                           text-xs
                           tracking-[0.18em]
                           uppercase
                           text-[#A48D78]"
                >

                    @if(Auth::user()->isStaff())

                        Loyalty Scanner

                    @else

                        Beauty & Wellness

                    @endif

                </div>


                {{-- USER --}}

                <div class="text-right">

                    <p class="text-sm text-[#5C4C40]">

                        {{ Auth::user()->name }}

                    </p>

                    <p
                        class="text-[10px]
                               uppercase
                               tracking-[0.12em]
                               text-[#A48D78]"
                    >

                        {{ Auth::user()->role }}

                    </p>

                </div>

            </div>

        </header>


        {{-- ===================================================== --}}
        {{-- PAGE HEADER --}}
        {{-- ===================================================== --}}

        @isset($header)

            <div
                class="px-4
                       sm:px-6
                       lg:px-8
                       pt-8"
            >

                <div class="max-w-7xl mx-auto">

                    {{ $header }}

                </div>

            </div>

        @endisset


        {{-- ===================================================== --}}
        {{-- PAGE CONTENT --}}
        {{-- ===================================================== --}}

        <main
            class="px-4
                   sm:px-6
                   lg:px-8
                   py-8"
        >

            <div class="max-w-7xl mx-auto">

                {{ $slot }}

            </div>

        </main>

    </div>

</div>

</body>

</html>
