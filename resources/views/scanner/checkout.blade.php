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