<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Loyalty Verification
            </p>

            <h1 class="page-title">
                Membership Verified
            </h1>
        </div>
    </x-slot>

    @php
        $customer = $membership->customer;
        $plan = $membership->loyaltyPlan;
    @endphp

    <div class="max-w-4xl">

        <div class="rounded-2xl bg-[#A48D78] text-white p-7 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:justify-between gap-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-white/70">
                        Martinis & Manicures
                    </p>

                    <h2 class="font-serif text-3xl text-white mt-2">
                        Active Loyalty Member
                    </h2>
                </div>

                <span class="self-start rounded-full bg-[#FAF9F6]
                             text-[#6A5849] px-4 py-1.5
                             text-xs font-semibold">
                    ACTIVE
                </span>
            </div>

            <div class="mt-8">
                <p class="text-sm text-white/70">
                    Customer
                </p>

                <p class="text-2xl font-medium mt-1">
                    {{ $customer->first_name }}
                    {{ $customer->last_name }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-8">
                <div>
                    <p class="text-xs text-white/60">
                        Membership
                    </p>

                    <p class="font-medium mt-1">
                        {{ $membership->membership_code }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-white/60">
                        Discount
                    </p>

                    <p class="text-2xl font-semibold mt-1">
                        {{ number_format($plan->discount_percentage, 0) }}%
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

        <div class="theme-card mt-6 p-6 sm:p-8">
            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                    Services
                </p>

                <h3 class="font-serif text-2xl text-[#493B32] mt-1">
                    Select Customer Services
                </h3>

                <p class="text-sm text-[#8B796A] mt-2">
                    Select all services received during this visit.
                    Variable-price services require the actual amount before checkout.
                </p>
            </div>

            <form method="POST" action="{{ route('scanner.calculate') }}">
                @csrf

                <input type="hidden" name="membership_id" value="{{ $membership->id }}">

                <div class="space-y-3">
                    @forelse($services as $service)
                        <label
                            class="flex flex-col gap-4 rounded-xl border border-[#E6DAC8]
                                   bg-[#FAF9F6] p-4 sm:p-5 cursor-pointer
                                   hover:border-[#CBB9A4] hover:bg-[#F4F1EA]
                                   transition">

                            <div class="flex items-center justify-between gap-5">
                                <div class="flex items-center gap-4">
                                    <input
                                        type="checkbox"
                                        name="services[]"
                                        value="{{ $service->id }}"
                                        class="h-5 w-5 rounded border-[#CBB9A4]
                                               text-[#A48D78] focus:ring-[#A48D78]"
                                    >

                                    <div>
                                        <p class="font-medium text-[#493B32]">
                                            {{ $service->name }}
                                        </p>

                                        @if($service->discount_eligible)
                                            <p class="text-xs text-[#A48D78] mt-1">
                                                Counts toward minimum spend
                                            </p>
                                        @else
                                            <p class="text-xs text-[#8B796A] mt-1">
                                                Not eligible for loyalty discount
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="font-semibold text-[#493B32] whitespace-nowrap">
                                        @if((float) $service->price > 0)
                                            PHP {{ number_format($service->price, 2) }}
                                        @else
                                            Variable price
                                        @endif
                                    </p>

                                    @if($service->discount_eligible)
                                        <p class="text-xs text-[#A48D78] mt-1">
                                            -{{ number_format($plan->discount_percentage, 0) }}%
                                        </p>
                                    @endif
                                </div>
                            </div>

                            @if((float) $service->price <= 0)
                                <div class="sm:ml-9">
                                    <label
                                        for="custom_price_{{ $service->id }}"
                                        class="block text-xs font-semibold uppercase tracking-[0.14em] text-[#8B796A]">
                                        Actual Price
                                    </label>

                                    <input
                                        id="custom_price_{{ $service->id }}"
                                        type="number"
                                        name="custom_prices[{{ $service->id }}]"
                                        value="{{ old('custom_prices.' . $service->id) }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="0.00"
                                        class="mt-2 w-full sm:max-w-xs rounded-lg border-[#E6DAC8]
                                               bg-white text-[#493B32]
                                               focus:border-[#A48D78]
                                               focus:ring-[#A48D78]"
                                    >
                                </div>
                            @endif
                        </label>
                    @empty
                        <div class="rounded-xl bg-[#F4F1EA] p-8 text-center">
                            <p class="text-[#8B796A]">
                                No active services available.
                            </p>
                        </div>
                    @endforelse
                </div>

                @error('services')
                    <div class="mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                        <p class="text-red-600 text-sm">
                            Please select at least one service.
                        </p>
                    </div>
                @enderror

                @error('custom_prices')
                    <div class="mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                        <p class="text-red-600 text-sm">
                            {{ $message }}
                        </p>
                    </div>
                @enderror

                @if($services->isNotEmpty())
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3
                                border-t border-[#E6DAC8] mt-6 pt-6">
                        <button type="submit" class="btn-primary text-center">
                            Calculate Discount
                        </button>

                        <a href="{{ route('scanner.index') }}" class="btn-secondary text-center">
                            Cancel
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

</x-app-layout>
