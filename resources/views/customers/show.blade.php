@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Customer Profile
            </p>

            <h1 class="page-title">
                {{ $customer->first_name }} {{ $customer->last_name }}
            </h1>
        </div>
    </x-slot>

    @php
        $membership = $customer->loyaltyMembership;
        $plan = $membership?->loyaltyPlan;
    @endphp

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- CUSTOMER INFO --}}
        <div class="theme-card p-6">

            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                Customer Information
            </p>

            <div class="mt-5 space-y-4">

                <div>
                    <p class="text-xs text-[#8B796A]">
                        Full Name
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-[#8B796A]">
                        Mobile Number
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $customer->phone ?: 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-[#8B796A]">
                        Birth Date
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $customer->birth_date
                            ? \Carbon\Carbon::parse($customer->birth_date)->format('M d, Y')
                            : 'Not provided' }}
                    </p>
                </div>

            </div>

            <div class="mt-6">
                <a
                    href="{{ route('customers.edit', $customer) }}"
                    class="btn-secondary inline-flex">
                    Edit Customer
                </a>
            </div>

        </div>


        {{-- DIGITAL LOYALTY CARD --}}
        <div class="xl:col-span-2">

            @if($membership)

                <div class="relative overflow-hidden rounded-2xl
                            bg-[#A48D78] text-[#FAF9F6]
                            shadow-sm p-7 sm:p-9">

                    {{-- Decorative circles --}}
                    <div class="absolute -right-16 -top-16 w-48 h-48
                                rounded-full bg-white/10">
                    </div>

                    <div class="absolute -left-16 -bottom-20 w-56 h-56
                                rounded-full bg-white/5">
                    </div>


                    <div class="relative">

                        <div class="flex flex-col sm:flex-row
                                    sm:items-start sm:justify-between gap-6">

                            <div>

                                <p class="text-[10px] uppercase
                                          tracking-[0.35em] text-white/70">
                                    Martinis & Manicures
                                </p>

                                <h2 class="text-3xl text-white mt-2">
                                    Loyalty Member
                                </h2>

                            </div>

                            @if($membership->status === 'active')

                                <span class="self-start rounded-full
                                             bg-[#FAF9F6] text-[#6A5849]
                                             px-4 py-1.5 text-xs font-semibold">
                                    ACTIVE
                                </span>

                            @else

                                <span class="self-start rounded-full
                                             bg-white/20 text-white
                                             px-4 py-1.5 text-xs font-semibold">
                                    {{ strtoupper($membership->status) }}
                                </span>

                            @endif

                        </div>


                        <div class="mt-10">

                            <p class="text-sm text-white/70">
                                Member
                            </p>

                            <p class="text-2xl font-medium mt-1">
                                {{ $customer->first_name }}
                                {{ $customer->last_name }}
                            </p>

                        </div>


                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-8">

                            <div>
                                <p class="text-xs text-white/60">
                                    Membership No.
                                </p>

                                <p class="font-medium mt-1">
                                    {{ $membership->membership_code }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-white/60">
                                    Member Discount
                                </p>

                                <p class="text-xl font-semibold mt-1">
                                    {{ number_format($plan?->discount_percentage ?? 0, 0) }}%
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-white/60">
                                    Valid Until
                                </p>

                                <p class="font-medium mt-1">
                                    {{ $membership->expires_at
                                        ? $membership->expires_at->format('M d, Y')
                                        : 'No Expiration' }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- MEMBERSHIP DETAILS --}}
                <div class="theme-card p-6 mt-6">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                                Membership Details
                            </p>

                            <h3 class="text-xl mt-1">
                                {{ $plan?->name ?? 'Loyalty Plan' }}
                            </h3>
                        </div>

                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4
                                gap-5 mt-6">

                        <div>
                            <p class="text-xs text-[#8B796A]">
                                Card Price
                            </p>

                            <p class="font-medium text-[#493B32] mt-1">
                                ₱{{ number_format($plan?->price ?? 0, 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-[#8B796A]">
                                Discount
                            </p>

                            <p class="font-medium text-[#493B32] mt-1">
                                {{ number_format($plan?->discount_percentage ?? 0, 0) }}%
                            </p>
                        </div>

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

                        <div>
                            <p class="text-xs text-[#8B796A]">
                                Validity
                            </p>

                            <p class="font-medium text-[#493B32] mt-1">
                                {{ $plan?->validity_months ?? '—' }}
                                {{ ($plan?->validity_months ?? 0) == 1 ? 'month' : 'months' }}
                            </p>
                        </div>

                    </div>

                </div>


                {{-- QR PLACEHOLDER --}}
                <div class="theme-card p-6 mt-6">

                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                        Membership QR
                    </p>

                    <h3 class="text-xl mt-1">
                        Scan Loyalty Card
                    </h3>

                    <div class="mt-6 flex flex-col items-center">

                        <div class="bg-white p-5 rounded-xl border border-[#E6DAC8]">
                            {!! QrCode::size(220)->generate($membership->qr_token) !!}
                        </div>

                        <p class="text-sm text-[#8B796A] mt-4 text-center max-w-md">
                            Staff can scan this QR code to verify the customer's membership
                            and apply the loyalty discount.
                        </p>

                        <p class="text-xs text-[#A48D78] mt-2">
                            {{ $membership->membership_code }}
                        </p>

                    </div>

                </div>

            @else

                <div class="theme-card p-8 text-center">

                    <h2 class="text-2xl">
                        No Loyalty Membership
                    </h2>

                    <p class="text-sm text-[#8B796A] mt-2">
                        This customer does not currently have a loyalty membership.
                    </p>

                </div>

            @endif

        </div>

    </div>


    <div class="mt-6">

        <a
            href="{{ route('customers.index') }}"
            class="text-sm text-[#A48D78] hover:text-[#7C6757]">
            ← Back to Customers
        </a>

    </div>

</x-app-layout>