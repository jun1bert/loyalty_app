<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Loyalty Management
            </p>

            <h1 class="page-title">
                Membership Details
            </h1>
        </div>
    </x-slot>


    <div class="max-w-5xl space-y-6">


        {{-- BACK BUTTON --}}
        <div>
            <a
                href="{{ route('memberships.index') }}"
                class="text-sm font-medium text-[#A48D78] hover:text-[#7C6757]"
            >
                ← Back to Memberships
            </a>
        </div>


        {{-- ====================================================== --}}
        {{-- DIGITAL LOYALTY CARD --}}
        {{-- ====================================================== --}}

        <div class="theme-card overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2">


                {{-- LEFT SIDE --}}
                <div class="p-8 sm:p-10 bg-[#493B32] text-[#FAF9F6]">

                    <p class="text-[10px] uppercase tracking-[0.35em] text-[#D8C6B4]">
                        Martinis & Manicures
                    </p>

                    <h2 class="font-serif text-3xl mt-5 text-[#FAF9F6]">
                        Loyalty Card
                    </h2>


                    <div class="mt-10">

                        <p class="text-xs uppercase tracking-[0.2em] text-[#D8C6B4]">
                            Member
                        </p>

                        <p class="font-serif text-2xl mt-2">
                            {{ $membership->customer->first_name }}
                            {{ $membership->customer->last_name }}
                        </p>

                    </div>


                    <div class="mt-8">

                        <p class="text-xs uppercase tracking-[0.2em] text-[#D8C6B4]">
                            Membership Number
                        </p>

                        <p class="text-lg tracking-[0.12em] mt-2">
                            {{ $membership->membership_code }}
                        </p>

                    </div>


                    <div class="mt-8 flex items-end justify-between gap-6">

                        <div>

                            <p class="text-xs uppercase tracking-[0.2em] text-[#D8C6B4]">
                                Plan
                            </p>

                            <p class="mt-2">
                                {{ $membership->loyaltyPlan?->name ?? '—' }}
                            </p>

                        </div>


                        <div class="text-right">

                            <p class="text-xs uppercase tracking-[0.2em] text-[#D8C6B4]">
                                Discount
                            </p>

                            <p class="font-serif text-3xl mt-1">
                                {{ number_format(
                                    $membership->loyaltyPlan?->discount_percentage ?? 0,
                                    0
                                ) }}%
                            </p>

                        </div>

                    </div>

                </div>


                {{-- RIGHT SIDE / QR --}}
                <div class="p-8 sm:p-10 flex flex-col items-center justify-center">

                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                        Membership QR
                    </p>

                    <div class="mt-5 bg-white rounded-xl border border-[#E6DAC8] p-5">

                        {!! QrCode::size(220)
                            ->margin(1)
                            ->generate($membership->qr_token) !!}

                    </div>

                    <p class="text-sm text-[#8B796A] text-center mt-5 max-w-xs">
                        Scan this QR code when the customer visits
                        Martinis & Manicures.
                    </p>

                </div>

            </div>

        </div>


        {{-- ====================================================== --}}
        {{-- MEMBERSHIP INFORMATION --}}
        {{-- ====================================================== --}}

        <div class="theme-card p-6 sm:p-8">

            <div class="mb-6">

                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                    Membership Information
                </p>

                <h2 class="font-serif text-2xl text-[#493B32] mt-1">
                    Details
                </h2>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">


                {{-- CUSTOMER --}}
                <div>

                    <p class="text-xs text-[#8B796A]">
                        Customer
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $membership->customer->first_name }}
                        {{ $membership->customer->last_name }}
                    </p>

                </div>


                {{-- PLAN --}}
                <div>

                    <p class="text-xs text-[#8B796A]">
                        Loyalty Plan
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $membership->loyaltyPlan?->name ?? '—' }}
                    </p>

                </div>


                {{-- ACTIVATED --}}
                <div>

                    <p class="text-xs text-[#8B796A]">
                        Activated
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">

                        {{ $membership->activated_at
                            ? $membership->activated_at->format('M d, Y')
                            : '—' }}

                    </p>

                </div>


                {{-- EXPIRATION --}}
                <div>

                    <p class="text-xs text-[#8B796A]">
                        Expiration
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">

                        {{ $membership->expires_at
                            ? $membership->expires_at->format('M d, Y')
                            : 'No Expiration' }}

                    </p>

                </div>


                {{-- DISCOUNT --}}
                <div>

                    <p class="text-xs text-[#8B796A]">
                        Discount
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">

                        {{ number_format(
                            $membership->loyaltyPlan?->discount_percentage ?? 0,
                            0
                        ) }}%

                    </p>

                </div>


                {{-- MEMBERSHIP NUMBER --}}
                <div>

                    <p class="text-xs text-[#8B796A]">
                        Membership Number
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $membership->membership_code }}
                    </p>

                </div>


                {{-- STATUS --}}
                <div>

                    <p class="text-xs text-[#8B796A] mb-2">
                        Status
                    </p>

                    @if(
                        $membership->status === 'active'
                        &&
                        (!$membership->expires_at || $membership->expires_at->isFuture())
                    )

                        <span class="badge-active">
                            Active
                        </span>

                    @elseif(
                        $membership->expires_at
                        &&
                        $membership->expires_at->isPast()
                    )

                        <span class="badge-inactive">
                            Expired
                        </span>

                    @else

                        <span class="badge-inactive">
                            {{ ucfirst($membership->status) }}
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- ====================================================== --}}
        {{-- CUSTOMER CONTACT --}}
        {{-- ====================================================== --}}

        <div class="theme-card p-6 sm:p-8">

            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                Customer Information
            </p>

            <h2 class="font-serif text-2xl text-[#493B32] mt-1 mb-6">
                Contact Details
            </h2>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div>

                    <p class="text-xs text-[#8B796A]">
                        Email
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $membership->customer->user?->email ?? 'No app account yet' }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-[#8B796A]">
                        Phone
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $membership->customer->phone ?? '—' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- BACK --}}
        <div>

            <a
                href="{{ route('memberships.index') }}"
                class="btn-secondary inline-flex"
            >
                ← Back to Memberships
            </a>

        </div>

    </div>

</x-app-layout>
