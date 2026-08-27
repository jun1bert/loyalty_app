<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Loyalty Plans
            </p>

            <h1 class="page-title">
                Edit Loyalty Plan
            </h1>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="theme-card p-6 sm:p-8">

            <form method="POST"
                  action="{{ route('loyalty-plans.update', $loyaltyPlan) }}"
                  class="space-y-6">

                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Plan Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $loyaltyPlan->name) }}"
                        class="theme-input"
                        required
                    >

                    @error('name')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

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
                            value="{{ old('price', $loyaltyPlan->price) }}"
                            step="0.01"
                            min="0"
                            class="theme-input pl-8"
                            required
                        >
                    </div>

                    @error('price')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

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
                            value="{{ old('discount_percentage', $loyaltyPlan->discount_percentage) }}"
                            step="0.01"
                            min="0"
                            max="100"
                            class="theme-input pr-10"
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

                <div>
                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Minimum Spend for Discount
                    </label>

                    <p class="text-xs text-[#8B796A] mb-2">
                        Discount applies only when eligible services reach this amount. Use 0 for no minimum.
                    </p>

                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#8B796A]">
                            PHP
                        </span>

                        <input
                            type="number"
                            name="minimum_spend"
                            value="{{ old('minimum_spend', $loyaltyPlan->minimum_spend ?? 0) }}"
                            step="0.01"
                            min="0"
                            class="theme-input pl-14"
                            required
                        >
                    </div>

                    @error('minimum_spend')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

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
                            value="{{ old('validity_months', $loyaltyPlan->validity_months) }}"
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

                <div class="border-t border-[#E6DAC8] pt-5">

                    <label class="flex items-center gap-3 cursor-pointer">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="rounded border-[#CBB9A4] text-[#A48D78] focus:ring-[#A48D78]"
                            {{ old('is_active', $loyaltyPlan->is_active) ? 'checked' : '' }}
                        >

                        <div>
                            <p class="text-sm font-medium text-[#493B32]">
                                Active Plan
                            </p>

                            <p class="text-xs text-[#8B796A]">
                                Customers can avail this plan while it is active.
                            </p>
                        </div>

                    </label>

                </div>

                <div class="rounded-xl bg-[#E6DAC8]/50 p-5">

                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                        Current Plan
                    </p>

                    <p class="font-serif text-xl text-[#493B32] mt-2">
                        {{ $loyaltyPlan->name }}
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-4 text-sm">

                        <div>
                            <p class="text-[#8B796A]">Card Price</p>
                            <p class="font-medium text-[#493B32]">
                                ₱{{ number_format($loyaltyPlan->price, 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[#8B796A]">Discount</p>
                            <p class="font-medium text-[#493B32]">
                                {{ number_format($loyaltyPlan->discount_percentage, 2) }}%
                            </p>
                        </div>

                        <div>
                            <p class="text-[#8B796A]">Minimum Spend</p>
                            <p class="font-medium text-[#493B32]">
                                PHP {{ number_format($loyaltyPlan->minimum_spend ?? 0, 2) }}
                            </p>
                        </div>

                    </div>

                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">

                    <button type="submit"
                            class="btn-primary text-center">
                        Update Loyalty Plan
                    </button>

                    <a href="{{ route('loyalty-plans.index') }}"
                       class="btn-secondary text-center">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</x-app-layout>
