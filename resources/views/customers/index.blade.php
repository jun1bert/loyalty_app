<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                    Loyalty Management
                </p>

                <h1 class="page-title">
                    Customers
                </h1>
            </div>

            <a
                href="{{ route('customers.create') }}"
                class="btn-primary inline-flex items-center justify-center">

                + Add Customer

            </a>

        </div>

    </x-slot>

    @if(session('success'))
        <div class="mb-5 rounded-lg border border-[#E6DAC8]
                    bg-[#FAF9F6] px-4 py-3 text-sm text-[#5C4C40]">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('customers.index') }}" class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center">
        <input
            type="search"
            name="search"
            value="{{ $search }}"
            placeholder="Search customers, phone, membership, or plan"
            class="theme-input sm:max-w-md"
        >

        <div class="flex gap-2">
            <button type="submit" class="btn-primary">
                Search
            </button>

            @if($search !== '')
                <a href="{{ route('customers.index') }}" class="btn-secondary">
                    Clear
                </a>
            @endif
        </div>
    </form>

    <div class="theme-card overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="theme-table-header">

                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Membership
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Discount
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Expires
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right font-semibold">
                            Actions
                        </th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($customers as $customer)

                        @php
                            $membership = $customer->loyaltyMembership;
                        @endphp

                        <tr class="border-t border-[#E6DAC8]
                                   hover:bg-[#F4F1EA]/60 transition">

                            <td class="px-6 py-4">

                                <p class="font-medium text-[#493B32]">
                                    {{ $customer->first_name }}
                                    {{ $customer->last_name }}
                                </p>

                                @if($customer->phone)
                                    <p class="text-xs text-[#8B796A] mt-1">
                                        {{ $customer->phone }}
                                    </p>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                @if($membership)

                                    <p class="font-medium text-[#493B32]">
                                        {{ $membership->membership_code }}
                                    </p>

                                    <p class="text-xs text-[#8B796A] mt-1">
                                        {{ $membership->loyaltyPlan?->name }}
                                    </p>

                                @else

                                    <span class="text-[#8B796A]">
                                        No membership
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                @if($membership?->loyaltyPlan)

                                    <span class="font-medium text-[#A48D78]">
                                        {{ number_format($membership->loyaltyPlan->discount_percentage, 0) }}%
                                    </span>

                                @else
                                    —
                                @endif

                            </td>

                            <td class="px-6 py-4 text-[#5C4C40]">

                                @if($membership?->expires_at)
                                    {{ $membership->expires_at->format('M d, Y') }}
                                @else
                                    —
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                @if($membership && $membership->status === 'active')

                                    <span class="badge-active">
                                        Active
                                    </span>

                                @elseif($membership)

                                    <span class="badge-inactive">
                                        {{ ucfirst($membership->status) }}
                                    </span>

                                @else

                                    <span class="badge-inactive">
                                        None
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-4">

                                    <a
                                        href="{{ route('customers.show', $customer) }}"
                                        class="text-[#A48D78] hover:text-[#7C6757] font-medium">
                                        View
                                    </a>

                                    <a
                                        href="{{ route('customers.edit', $customer) }}"
                                        class="text-[#A48D78] hover:text-[#7C6757] font-medium">
                                        Edit
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="px-6 py-12 text-center text-[#8B796A]">
                                {{ $search !== '' ? 'No customers match your search.' : 'No customers have been registered yet.' }}
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>
