<x-app-layout>

    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78] mb-1">
                Loyalty Verification
            </p>

            <h1 class="page-title">
                QR Scanner
            </h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">

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

        <div class="theme-card p-6 sm:p-8">

            <div class="text-center">

                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                    Membership Scanner
                </p>

                <h2 class="font-serif text-2xl text-[#493B32] mt-2">
                    Scan Customer Loyalty Card
                </h2>

                <p class="text-sm text-[#8B796A] mt-2">
                    Position the customer's QR code inside the camera frame.
                </p>

            </div>


            {{-- CAMERA --}}
            <div class="mt-6">

                <div
                    id="qr-reader"
                    class="overflow-hidden rounded-xl border border-[#E6DAC8]">
                </div>

            </div>


            {{-- Status --}}
            <div id="scanner-status"
                 class="mt-4 text-center text-sm text-[#8B796A]">

                Waiting for camera...

            </div>


            {{-- Hidden verification form --}}
            <form
                id="qr-form"
                method="POST"
                action="{{ route('scanner.verify') }}">

                @csrf

                <input
                    type="hidden"
                    id="qr_token"
                    name="qr_token"
                >

            </form>


            {{-- Manual fallback --}}
            <div class="border-t border-[#E6DAC8] mt-8 pt-6">

                <p class="text-xs uppercase tracking-[0.2em] text-[#A48D78]">
                    Manual Verification
                </p>

                <p class="text-sm text-[#8B796A] mt-2">
                    If the camera is unavailable, you can still enter the QR token manually.
                </p>

                <form
                    method="POST"
                    action="{{ route('scanner.verify') }}"
                    class="mt-4 flex flex-col sm:flex-row gap-3">

                    @csrf

                    <input
                        type="text"
                        name="qr_token"
                        class="theme-input flex-1"
                        placeholder="Enter QR token"
                        required
                    >

                    <button
                        type="submit"
                        class="btn-primary whitespace-nowrap">
                        Verify
                    </button>

                </form>

            </div>

        </div>

    </div>


    {{-- QR Scanner Library --}}
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const status = document.getElementById('scanner-status');
            const tokenInput = document.getElementById('qr_token');
            const form = document.getElementById('qr-form');

            let alreadyScanned = false;

            function onScanSuccess(decodedText) {

                if (alreadyScanned) {
                    return;
                }

                alreadyScanned = true;

                status.textContent = 'QR detected. Verifying membership...';

                tokenInput.value = decodedText;

                form.submit();
            }

            function onScanFailure(error) {
                // Ignore normal scan failures while camera is searching.
            }

            const scanner = new Html5QrcodeScanner(
                'qr-reader',
                {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                    rememberLastUsedCamera: true,
                    aspectRatio: 1.0
                },
                false
            );

            scanner.render(onScanSuccess, onScanFailure);

            status.textContent = 'Camera ready. Scan a loyalty QR code.';
        });
    </script>

</x-app-layout>