<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                    Service Management
                </p>

                <h1 class="page-title">
                    Services
                </h1>
            </div>

            <a href="{{ route('services.create') }}"
               class="btn-primary inline-flex items-center justify-center">
                + Add Service
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
                        <th class="px-6 py-4 text-left font-semibold">Service</th>
                        <th class="px-6 py-4 text-left font-semibold">Price</th>
                        <th class="px-6 py-4 text-left font-semibold">Discount</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($services as $service)
                        <tr class="border-t border-[#E6DAC8] hover:bg-[#F4F1EA]/60 transition">
                            <td class="px-6 py-4 font-medium text-[#493B32]">
                                {{ $service->name }}
                            </td>

                            <td class="px-6 py-4 text-[#5C4C40]">
                                PHP {{ number_format($service->price, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                @if($service->discount_eligible)
                                    <span class="badge-active">Eligible</span>
                                @else
                                    <span class="badge-inactive">Not Eligible</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($service->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end items-center gap-4">
                                    <a href="{{ route('services.show', $service) }}"
                                       class="text-[#A48D78] hover:text-[#7C6757] font-medium">
                                        View
                                    </a>

                                    <a href="{{ route('services.edit', $service) }}"
                                       class="text-[#A48D78] hover:text-[#7C6757] font-medium">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('services.destroy', $service) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-500 hover:text-red-700 font-medium"
                                            onclick="return confirm('Delete this service?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[#8B796A]">
                                No services have been created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
