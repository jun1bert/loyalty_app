<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Loyalty Management
            </p>

            <h1 class="page-title">
                Transactions
            </h1>
        </div>
    </x-slot>

    <div class="theme-card overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="theme-table-header">

                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">
                            Transaction
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Subtotal
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Discount
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Total
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Processed By
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Date
                        </th>

                        <th class="px-6 py-4 text-right font-semibold">
                            Action
                        </th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($transactions as $transaction)

                        <tr class="border-t border-[#E6DAC8] hover:bg-[#F4F1EA]/60">

                            <td class="px-6 py-4 font-medium text-[#493B32]">
                                #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="px-6 py-4">

                                <p class="font-medium text-[#493B32]">
                                    {{ $transaction->customer->first_name }}
                                    {{ $transaction->customer->last_name }}
                                </p>

                                <p class="text-xs text-[#8B796A] mt-1">
                                    {{ $transaction->membership->membership_code }}
                                </p>

                            </td>

                            <td class="px-6 py-4 text-[#5C4C40]">
                                ₱{{ number_format($transaction->subtotal, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-medium text-[#A48D78]">
                                    - ₱{{ number_format($transaction->discount_amount, 2) }}
                                </p>

                                <p class="text-xs text-[#8B796A]">
                                    {{ number_format($transaction->discount_percentage, 0) }}%
                                </p>
                            </td>

                            <td class="px-6 py-4 font-semibold text-[#493B32]">
                                ₱{{ number_format($transaction->total_amount, 2) }}
                            </td>

                            <td class="px-6 py-4 text-[#5C4C40]">
                                {{ $transaction->processedBy?->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-[#5C4C40]">
                                {{ $transaction->transaction_date->format('M d, Y h:i A') }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a
                                    href="{{ route('transactions.show', $transaction) }}"
                                    class="text-[#A48D78] hover:text-[#7C6757] font-medium">
                                    View
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="px-6 py-12 text-center text-[#8B796A]">
                                No loyalty transactions yet.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>