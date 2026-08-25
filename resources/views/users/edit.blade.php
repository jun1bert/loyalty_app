<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                User Management
            </p>

            <h1 class="page-title">
                Edit User
            </h1>
        </div>
    </x-slot>


    <div class="max-w-2xl">

        @if(session('error'))
            <div class="mb-5 rounded-lg border border-red-200
                        bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif


        <div class="theme-card p-6 sm:p-8">

            <form
                method="POST"
                action="{{ route('users.update', $user) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')


                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
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
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="theme-input"
                        required
                    >

                    @error('email')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Role
                    </label>

                    <select
                        name="role"
                        class="theme-input"
                        required
                    >

                        <option
                            value="admin"
                            {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>

                        <option
                            value="management"
                            {{ old('role', $user->role) === 'management' ? 'selected' : '' }}
                        >
                            Management
                        </option>

                        <option
                            value="staff"
                            {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}
                        >
                            Staff
                        </option>

                    </select>

                    <p class="text-xs text-[#8B796A] mt-2">
                        Staff can only use the QR scanner.
                        Management can manage services, loyalty plans,
                        customers, QR scanning and transactions.
                    </p>

                    @error('role')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div class="border-t border-[#E6DAC8] pt-6">

                    <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                        Password
                    </p>

                    <p class="text-sm text-[#8B796A] mb-5">
                        Leave these fields empty if you do not want to change the password.
                    </p>


                    <div class="space-y-5">

                        <div>

                            <label class="block text-sm font-medium text-[#493B32] mb-2">
                                New Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="theme-input"
                            >

                            @error('password')
                                <p class="text-red-600 text-xs mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div>

                            <label class="block text-sm font-medium text-[#493B32] mb-2">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="theme-input"
                            >

                        </div>

                    </div>

                </div>


                @if(auth()->id() === $user->id)

                    <div class="rounded-xl border border-[#E6DAC8]
                                bg-[#F4F1EA] p-4">

                        <p class="text-sm font-medium text-[#493B32]">
                            This is your account
                        </p>

                        <p class="text-xs text-[#8B796A] mt-1">
                            The system will prevent you from removing your own administrator role.
                        </p>

                    </div>

                @endif


                <div class="flex flex-col sm:flex-row gap-3 pt-2">

                    <button
                        type="submit"
                        class="btn-primary text-center"
                    >
                        Update User
                    </button>

                    <a
                        href="{{ route('users.index') }}"
                        class="btn-secondary text-center"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>