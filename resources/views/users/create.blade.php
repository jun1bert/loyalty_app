<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                User Management
            </p>

            <h1 class="page-title">
                Add User
            </h1>
        </div>
    </x-slot>


    <div class="max-w-2xl">

        <div class="theme-card p-6 sm:p-8">

            <form
                method="POST"
                action="{{ route('users.store') }}"
                class="space-y-6"
            >

                @csrf


                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
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
                        value="{{ old('email') }}"
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
                        <option value="">
                            Select role
                        </option>

                        <option
                            value="admin"
                            {{ old('role') === 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>

                        <option
                            value="management"
                            {{ old('role') === 'management' ? 'selected' : '' }}
                        >
                            Management
                        </option>

                        <option
                            value="staff"
                            {{ old('role') === 'staff' ? 'selected' : '' }}
                        >
                            Staff
                        </option>
                    </select>

                    <p class="text-xs text-[#8B796A] mt-2">
                        Staff can only use the QR scanner. Management can manage
                        services, loyalty plans, customers and transactions.
                    </p>

                    @error('role')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="theme-input"
                        required
                    >

                    @error('password')
                        <p class="text-red-600 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label class="block text-sm font-medium text-[#493B32] mb-2">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="theme-input"
                        required
                    >

                </div>


                <div class="flex flex-col sm:flex-row gap-3 pt-2">

                    <button
                        type="submit"
                        class="btn-primary text-center"
                    >
                        Create User
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