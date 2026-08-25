<x-app-layout>

    <x-slot name="header">

        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Overview
            </p>

            <h1 class="page-title">
                Dashboard
            </h1>
        </div>

    </x-slot>


    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Customers --}}
        <div class="theme-card p-6">

            <p class="text-sm text-[#8B796A]">
                Total Customers
            </p>

            <p class="font-serif text-4xl text-[#493B32] mt-3">
                0
            </p>

            <p class="text-xs text-[#A48D78] mt-2">
                Loyalty customers
            </p>

        </div>


        {{-- Memberships --}}
        <div class="theme-card p-6">

            <p class="text-sm text-[#8B796A]">
                Active Memberships
            </p>

            <p class="font-serif text-4xl text-[#493B32] mt-3">
                0
            </p>

            <p class="text-xs text-[#A48D78] mt-2">
                Currently active
            </p>

        </div>


        {{-- Services --}}
        <div class="theme-card p-6">

            <p class="text-sm text-[#8B796A]">
                Services
            </p>

            <p class="font-serif text-4xl text-[#493B32] mt-3">
                {{ \App\Models\Service::where('is_active', true)->count() }}
            </p>

            <p class="text-xs text-[#A48D78] mt-2">
                Active services
            </p>

        </div>


        {{-- Discounts --}}
        <div class="theme-card p-6">

            <p class="text-sm text-[#8B796A]">
                Discounts Given
            </p>

            <p class="font-serif text-4xl text-[#493B32] mt-3">
                ₱0
            </p>

            <p class="text-xs text-[#A48D78] mt-2">
                This month
            </p>

        </div>

    </div>


    {{-- Welcome --}}
    <div class="theme-card mt-6 p-8">

        <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
            Martinis & Manicures
        </p>

        <h2 class="text-2xl mt-2">
            Loyalty Management
        </h2>

        <p class="text-sm text-[#7B6B5E] mt-3 max-w-2xl leading-6">
            Manage loyalty memberships, customer discounts,
            services and transactions from your dashboard.
        </p>

    </div>

</x-app-layout>