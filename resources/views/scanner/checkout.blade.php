<div class="theme-card mt-6 p-6">

    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
        Confirmation
    </p>

    <h3 class="text-xl mt-1">
        Complete Loyalty Transaction
    </h3>

    <p class="text-sm text-[#8B796A] mt-2">
        Confirming will save this visit, services, prices,
        discount, and staff member to the transaction history.
    </p>

    <div class="mt-5 rounded-xl border border-[#E6DAC8] bg-[#FAF9F6] p-4 text-sm">
        <div class="flex justify-between gap-4">
            <span class="text-[#8B796A]">Eligible subtotal</span>
            <span class="font-medium text-[#493B32]">PHP {{ number_format($eligibleSubtotal, 2) }}</span>
        </div>

        <div class="mt-2 flex justify-between gap-4">
            <span class="text-[#8B796A]">Minimum spend</span>
            <span class="font-medium text-[#493B32]">PHP {{ number_format($minimumSpend, 2) }}</span>
        </div>

        @if(!$meetsMinimumSpend)
            <p class="mt-3 rounded-lg bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700">
                Discount not applied because eligible services did not reach the minimum spend.
            </p>
        @endif
    </div>

    <form
        method="POST"
        action="{{ route('scanner.confirm') }}"
        class="mt-6">

        @csrf

        <input
            type="hidden"
            name="membership_id"
            value="{{ $membership->id }}"
        >

        @foreach($services as $service)
            <input
                type="hidden"
                name="services[]"
                value="{{ $service->id }}"
            >

            @if((float) $service->price <= 0)
                <input
                    type="hidden"
                    name="custom_prices[{{ $service->id }}]"
                    value="{{ number_format($servicePrices[$service->id], 2, '.', '') }}"
                >
            @endif
        @endforeach

        <div class="flex flex-col sm:flex-row gap-3">

            <button
                type="submit"
                class="btn-primary text-center">

                Confirm Transaction

            </button>

            <a
                href="{{ route('scanner.index') }}"
                class="btn-secondary text-center">

                Cancel

            </a>

        </div>

    </form>

</div>
