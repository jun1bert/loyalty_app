<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                    Administration
                </p>

                <h1 class="page-title">
                    User Management
                </h1>
            </div>

            <a
                href="{{ route('users.create') }}"
                class="btn-primary inline-flex items-center justify-center"
            >
                + Add User
            </a>

        </div>
    </x-slot>


    @if(session('success'))
        <div class="mb-5 rounded-lg border border-[#E6DAC8]
                    bg-[#FAF9F6] px-4 py-3 text-sm text-[#5C4C40]">
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="mb-5 rounded-lg border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    <div class="theme-card overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="theme-table-header">

                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">
                            Name
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Role
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Created
                        </th>

                        <th class="px-6 py-4 text-right font-semibold">
                            Actions
                        </th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                        <tr class="border-t border-[#E6DAC8]
                                   hover:bg-[#F4F1EA]/60 transition">

                            <td class="px-6 py-4">

                                <p class="font-medium text-[#493B32]">
                                    {{ $user->name }}
                                </p>

                                @if(auth()->id() === $user->id)
                                    <p class="text-xs text-[#A48D78] mt-1">
                                        Your account
                                    </p>
                                @endif

                            </td>


                            <td class="px-6 py-4 text-[#5C4C40]">
                                {{ $user->email }}
                            </td>


                            <td class="px-6 py-4">

                                @if($user->role === 'admin')

                                    <span class="badge-active">
                                        Admin
                                    </span>

                                @elseif($user->role === 'management')

                                    <span class="badge-active">
                                        Management
                                    </span>

                                @else

                                    <span class="badge-inactive">
                                        Staff
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4 text-[#5C4C40]">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="flex justify-end items-center gap-4">

                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        class="text-[#A48D78]
                                               hover:text-[#7C6757]
                                               font-medium"
                                    >
                                        Edit
                                    </a>

                                    @if(auth()->id() !== $user->id)

                                        <form
                                            method="POST"
                                            action="{{ route('users.destroy', $user) }}"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Delete this user account?')"
                                                class="text-red-500 hover:text-red-700 font-medium"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-[#8B796A]"
                            >
                                No staff accounts found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>