<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Customers
            </p>

            <h1 class="page-title">
                Edit Customer
            </h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">

        <div class="theme-card p-6 sm:p-8">

            <form method="POST"
                  action="{{ route('customers.update', $customer) }}"
                  class="space-y-6">

                @csrf
                @method('PUT')

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
                                value="{{ old('first_name', $customer->first_name) }}"
                                class="theme-input"
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
                                value="{{ old('last_name', $customer->last_name) }}"
                                class="theme-input"
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
                                value="{{ old('phone', $customer->phone) }}"
                                class="theme-input"
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
                                value="{{ old('birth_date', $customer->birth_date) }}"
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

                @if($customer->loyaltyMembership)
                    <div class="rounded-xl bg-[#E6DAC8]/50 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                            Membership
                        </p>

                        <p class="font-serif text-xl text-[#493B32] mt-2">
                            {{ $customer->loyaltyMembership->membership_code }}
                        </p>

                        <p class="text-sm text-[#6F5E51] mt-2">
                            Membership plan changes are managed separately from customer contact details.
                        </p>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3">

                    <button
                        type="submit"
                        class="btn-primary text-center">
                        Update Customer
                    </button>

                    <a
                        href="{{ route('customers.show', $customer) }}"
                        class="btn-secondary text-center">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
