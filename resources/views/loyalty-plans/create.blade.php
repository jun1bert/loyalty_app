<x-app-layout>

    <x-slot name="header">

        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Loyalty Plans
            </p>

            <h1 class="page-title">
                Add Loyalty Plan
            </h1>
        </div>

    </x-slot>


    <div class="max-w-2xl">

        <div class="theme-card p-6 sm:p-8">

            <form method="POST"
                  action="{{ route('loyalty-plans.store') }}"
                  class="space-y-6">

                @csrf


                {{-- Plan Name --}}
                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Plan Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="theme-input"
                        placeholder="Example: Premium Loyalty Card"
                        required
                    >

                    @error('name')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Card Price --}}
                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Card Price
                    </label>

                    <p class="text-xs text-[#8B796A] mb-2">
                        Amount the customer pays to avail this loyalty card.
                    </p>

                    <div class="relative">

                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#8B796A]">
                            ₱
                        </span>

                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            step="0.01"
                            min="0"
                            class="theme-input pl-8"
                            placeholder="0.00"
                            required
                        >

                    </div>

                    @error('price')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Discount --}}
                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Discount Percentage
                    </label>

                    <p class="text-xs text-[#8B796A] mb-2">
                        Discount members receive on eligible services.
                    </p>

                    <div class="relative">

                        <input
                            type="number"
                            name="discount_percentage"
                            value="{{ old('discount_percentage') }}"
                            step="0.01"
                            min="0"
                            max="100"
                            class="theme-input pr-10"
                            placeholder="10"
                            required
                        >

                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[#8B796A]">
                            %
                        </span>

                    </div>

                    @error('discount_percentage')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Validity --}}
                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Validity
                    </label>

                    <p class="text-xs text-[#8B796A] mb-2">
                        Number of months the membership remains active.
                    </p>

                    <div class="relative">

                        <input
                            type="number"
                            name="validity_months"
                            value="{{ old('validity_months', 12) }}"
                            min="1"
                            max="120"
                            class="theme-input pr-20"
                            required
                        >

                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[#8B796A]">
                            months
                        </span>

                    </div>

                    @error('validity_months')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Active --}}
                <div class="border-t border-[#E6DAC8] pt-5">

                    <label class="flex items-center gap-3 cursor-pointer">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="rounded border-[#CBB9A4]
                                   text-[#A48D78]
                                   focus:ring-[#A48D78]"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        >

                        <div>

                            <p class="text-sm font-medium text-[#493B32]">
                                Active Plan
                            </p>

                            <p class="text-xs text-[#8B796A]">
                                Customers can avail this loyalty plan while it is active.
                            </p>

                        </div>

                    </label>

                </div>


                {{-- Preview --}}
                <div class="rounded-xl bg-[#E6DAC8]/50 p-5">

                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                        Example
                    </p>

                    <p class="font-serif text-xl text-[#493B32] mt-2">
                        Premium Loyalty Card
                    </p>

                    <p class="text-sm text-[#6F5E51] mt-2">
                        Customer purchases the card and receives the configured
                        discount on eligible services during the membership period.
                    </p>

                </div>


                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-2">

                    <button
                        type="submit"
                        class="btn-primary text-center">
                        Create Loyalty Plan
                    </button>

                    <a
                        href="{{ route('loyalty-plans.index') }}"
                        class="btn-secondary text-center">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>