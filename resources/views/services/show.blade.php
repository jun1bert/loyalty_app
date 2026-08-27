<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Services
            </p>

            <h1 class="page-title">
                Service Details
            </h1>
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-6">

        <div class="theme-card p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                        Service
                    </p>

                    <h2 class="font-serif text-3xl text-[#493B32] mt-2">
                        {{ $service->name }}
                    </h2>
                </div>

                @if($service->is_active)
                    <span class="badge-active self-start">Active</span>
                @else
                    <span class="badge-inactive self-start">Inactive</span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
                <div>
                    <p class="text-xs text-[#8B796A]">
                        Price
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        PHP {{ number_format($service->price, 2) }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-[#8B796A]">
                        Discount Eligible
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $service->discount_eligible ? 'Yes' : 'No' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-[#8B796A]">
                        Created
                    </p>

                    <p class="font-medium text-[#493B32] mt-1">
                        {{ $service->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a
                href="{{ route('services.edit', $service) }}"
                class="btn-primary text-center">
                Edit Service
            </a>

            <a
                href="{{ route('services.index') }}"
                class="btn-secondary text-center">
                Back to Services
            </a>
        </div>

    </div>

</x-app-layout>
