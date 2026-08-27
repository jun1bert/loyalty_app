<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Customers
            </p>

            <h1 class="page-title">
                Add Customer
            </h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">

        <div class="theme-card p-6 sm:p-8">

            <form method="POST"
                  action="{{ route('customers.store') }}"
                  class="space-y-6">

                @csrf

                {{-- Customer Information --}}
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-4">
                        Customer Information
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium text-[#493B32] mb-2">
                                First Name
                            </label>

                            <input
                                type="text"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                class="theme-input"
                                placeholder="Maria"
                                required
                            >

                            @error('first_name')
                                <p class="text-red-600 text-xs mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#493B32] mb-2">
                                Last Name
                            </label>

                            <input
                                type="text"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                class="theme-input"
                                placeholder="Santos"
                                required
                            >

                            @error('last_name')
                                <p class="text-red-600 text-xs mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#493B32] mb-2">
                                Mobile Number
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="theme-input"
                                placeholder="09XXXXXXXXX"
                            >

                            @error('phone')
                                <p class="text-red-600 text-xs mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#493B32] mb-2">
                                Birth Date
                            </label>

                            <input
                                type="date"
                                name="birth_date"
                                value="{{ old('birth_date') }}"
                                class="theme-input"
                            >

                            @error('birth_date')
                                <p class="text-red-600 text-xs mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Loyalty Plan --}}
                <div class="border-t border-[#E6DAC8] pt-6">

                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-2">
                        Loyalty Membership
                    </p>

                    <p class="text-sm text-[#8B796A] mb-4">
                        Select the loyalty card the customer is availing.
                    </p>

                    <div>
                        <label class="block text-sm font-medium text-[#493B32] mb-2">
                            Loyalty Plan
                        </label>

                        <select
                            name="loyalty_plan_id"
                            class="theme-input"
                            required
                        >
                            <option value="">
                                Select a loyalty plan
                            </option>

                            @foreach($plans as $plan)
                                <option
                                    value="{{ $plan->id }}"
                                    {{ old('loyalty_plan_id') == $plan->id ? 'selected' : '' }}
                                >
                                    {{ $plan->name }}
                                    — ₱{{ number_format($plan->price, 2) }}
                                    — {{ number_format($plan->discount_percentage, 0) }}% discount
                                </option>
                            @endforeach
                        </select>

                        @error('loyalty_plan_id')
                            <p class="text-red-600 text-xs mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Information Box --}}
                <div class="rounded-xl bg-[#E6DAC8]/50 p-5">

                    <p class="font-serif text-lg text-[#493B32]">
                        What happens after registration?
                    </p>

                    <p class="text-sm text-[#6F5E51] mt-2 leading-6">
                        The customer's loyalty membership will be activated immediately.
                        The system will automatically generate a unique membership code,
                        QR token, activation date, and expiration date based on the
                        selected loyalty plan.
                    </p>

                </div>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3">

                    <button
                        type="submit"
                        class="btn-primary text-center">
                        Create Customer & Activate Card
                    </button>

                    <a
                        href="{{ route('customers.index') }}"
                        class="btn-secondary text-center">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
