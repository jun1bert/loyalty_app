<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Services
            </h2>

            <a href="{{ route('services.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Add Service
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Service</th>
                            <th class="p-3 text-left">Price</th>
                            <th class="p-3 text-left">Discount</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($services as $service)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $service->name }}
                                </td>

                                <td class="p-3">
                                    ₱{{ number_format($service->price, 2) }}
                                </td>

                                <td class="p-3">
                                    {{ $service->discount_eligible ? 'Eligible' : 'Not Eligible' }}
                                </td>

                                <td class="p-3">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </td>

                                <td class="p-3 flex gap-2">
                                    <a href="{{ route('services.edit', $service) }}"
                                       class="text-blue-600">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('services.destroy', $service) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600"
                                                onclick="return confirm('Delete this service?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-5 text-center text-gray-500">
                                    No services yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>