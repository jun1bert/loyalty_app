<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                    Membership
                </p>

                <h1 class="page-title">
                    Loyalty Plans
                </h1>
            </div>

            <a href="{{ route('loyalty-plans.create') }}"
               class="btn-primary inline-flex items-center justify-center">

                + Add Loyalty Plan

            </a>

        </div>

    </x-slot>


    @if(session('success'))

        <div class="mb-5 rounded-lg border border-[#E6DAC8]
                    bg-[#FAF9F6] px-4 py-3 text-sm text-[#5C4C40]">

            {{ session('success') }}

        </div>

    @endif


    <div class="theme-card overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="theme-table-header">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold">
                            Plan
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Card Price
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Discount
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Minimum Spend
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Validity
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

                    @forelse($plans as $plan)

                        <tr class="border-t border-[#E6DAC8]
                                   hover:bg-[#F4F1EA]/60 transition">

                            <td class="px-6 py-4 font-medium text-[#493B32]">

                                {{ $plan->name }}

                            </td>


                            <td class="px-6 py-4 text-[#5C4C40]">

                                ₱{{ number_format($plan->price, 2) }}

                            </td>


                            <td class="px-6 py-4">

                                <span class="font-medium text-[#A48D78]">

                                    {{ number_format($plan->discount_percentage, 0) }}%

                                </span>

                            </td>


                            <td class="px-6 py-4 text-[#5C4C40]">

                                PHP {{ number_format($plan->minimum_spend ?? 0, 2) }}

                            </td>


                            <td class="px-6 py-4 text-[#5C4C40]">

                                {{ $plan->validity_months }}

                                {{ $plan->validity_months == 1 ? 'month' : 'months' }}

                            </td>


                            <td class="px-6 py-4">

                                @if($plan->is_active)

                                    <span class="badge-active">
                                        Active
                                    </span>

                                @else

                                    <span class="badge-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex justify-end items-center gap-4">

                                    <a
                                        href="{{ route('loyalty-plans.edit', $plan) }}"
                                        class="text-[#A48D78] hover:text-[#7C6757] font-medium">

                                        Edit

                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('loyalty-plans.destroy', $plan) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Delete this loyalty plan?')"
                                            class="text-red-500 hover:text-red-700 font-medium">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-12 text-center text-[#8B796A]">

                                No loyalty plans have been created yet.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>
