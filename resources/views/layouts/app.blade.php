<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Martinis & Manicures') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="antialiased">

<div
    x-data="{ sidebarOpen: false }"
    class="min-h-screen bg-[#F4F1EA]"
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
        class="fixed inset-y-0 left-0 z-50
               w-64
               bg-[#FAF9F6]
               border-r border-[#E6DAC8]
               transition-transform duration-300
               lg:translate-x-0"
    >

        <div class="flex h-full flex-col">


            {{-- ================================================= --}}
            {{-- BRAND --}}
            {{-- ================================================= --}}

            <div
                class="h-24 flex items-center justify-center
                       border-b border-[#E6DAC8]
                       px-6"
            >

                @if(Auth::user()->isStaff())

                    <a
                        href="{{ route('scanner.index') }}"
                        class="text-center"
                    >

                        <div
                            class="font-serif text-xl
                                   tracking-[0.15em]
                                   text-[#493B32]"
                        >
                            MARTINIS
                        </div>

                        <div
                            class="text-[10px]
                                   tracking-[0.35em]
                                   text-[#A48D78]
                                   mt-1"
                        >
                            & MANICURES
                        </div>

                    </a>

                @else

                    <a
                        href="{{ route('dashboard') }}"
                        class="text-center"
                    >

                        <div
                            class="font-serif text-xl
                                   tracking-[0.15em]
                                   text-[#493B32]"
                        >
                            MARTINIS
                        </div>

                        <div
                            class="text-[10px]
                                   tracking-[0.35em]
                                   text-[#A48D78]
                                   mt-1"
                        >
                            & MANICURES
                        </div>

                    </a>

                @endif

            </div>


            {{-- ================================================= --}}
            {{-- NAVIGATION --}}
            {{-- ================================================= --}}

            <nav
                class="flex-1 overflow-y-auto
                       px-4 py-6 space-y-2"
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
                               text-sm font-medium
                               transition

                        {{ request()->routeIs('dashboard')
                            ? 'bg-[#A48D78] text-white'
                            : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
                    >

                        <span>⌂</span>

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
                                   text-[#A48D78]"
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
                               text-sm font-medium
                               transition

                        {{ request()->routeIs('services.*')
                            ? 'bg-[#A48D78] text-white'
                            : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
                    >

                        <span>◇</span>

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
                               text-sm font-medium
                               transition

                        {{ request()->routeIs('loyalty-plans.*')
                            ? 'bg-[#A48D78] text-white'
                            : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
                    >

                        <span>♡</span>

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
                               text-sm font-medium
                               transition

                        {{ request()->routeIs('customers.*')
                            ? 'bg-[#A48D78] text-white'
                            : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
                    >

                        <span>♙</span>

                        <span>
                            Customers
                        </span>

                    </a>


                    <a
    href="{{ route('memberships.index') }}"
    class="flex items-center gap-3
           rounded-lg px-4 py-3
           text-sm font-medium transition

    {{ request()->routeIs('memberships.*')
        ? 'bg-[#A48D78] text-white'
        : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
>

    <span>▣</span>

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
                               text-sm font-medium
                               transition

                        {{ request()->routeIs('transactions.*')
                            ? 'bg-[#A48D78] text-white'
                            : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
                    >

                        <span>▤</span>

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
                                   text-[#A48D78]"
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
                                   text-[#A48D78]"
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
                           text-sm font-medium
                           transition

                    {{ request()->routeIs('scanner.*')
                        ? 'bg-[#A48D78] text-white'
                        : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
                >

                    <span>⌗</span>

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
                                   text-[#A48D78]"
                        >
                            Administration
                        </p>

                    </div>


                    <a
    href="{{ route('users.index') }}"
    class="flex items-center gap-3
           rounded-lg px-4 py-3
           text-sm font-medium transition

    {{ request()->routeIs('users.*')
        ? 'bg-[#A48D78] text-white'
        : 'text-[#5C4C40] hover:bg-[#E6DAC8]' }}"
>

    <span>♙</span>

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
                class="border-t
                       border-[#E6DAC8]
                       p-4"
            >

                <div class="px-3 mb-3">


                    {{-- USER NAME --}}

                    <p
                        class="text-sm
                               font-medium
                               text-[#493B32]"
                    >
                        {{ Auth::user()->name }}
                    </p>


                    {{-- ROLE --}}

                    <div class="mt-1">

                        @if(Auth::user()->isAdmin())

                            <span
                                class="inline-flex
                                       rounded-full
                                       bg-[#E6DAC8]
                                       px-2 py-1
                                       text-[9px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.15em]
                                       text-[#6A5849]"
                            >
                                Admin
                            </span>

                        @elseif(Auth::user()->isManagement())

                            <span
                                class="inline-flex
                                       rounded-full
                                       bg-[#E6DAC8]
                                       px-2 py-1
                                       text-[9px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.15em]
                                       text-[#6A5849]"
                            >
                                Management
                            </span>

                        @else

                            <span
                                class="inline-flex
                                       rounded-full
                                       bg-[#E6DAC8]
                                       px-2 py-1
                                       text-[9px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.15em]
                                       text-[#6A5849]"
                            >
                                Staff
                            </span>

                        @endif

                    </div>


                    {{-- EMAIL --}}

                    <p
                        class="text-xs
                               text-[#9B8A7C]
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
                               rounded-lg
                               px-3 py-2
                               text-sm
                               text-[#5C4C40]
                               hover:bg-[#E6DAC8]
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
            class="sticky top-0 z-30
                   h-16
                   bg-[#FAF9F6]/95
                   border-b border-[#E6DAC8]
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
                >

                    ☰

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