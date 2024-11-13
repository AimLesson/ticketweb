<x-home-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Claim Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Verification Form -->
                    <form action="{{ route('claim.verify') }}" method="GET">
                        @csrf
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="nama" id="nama" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" name="nik" id="nik" class="mt-1 block w-full" required>
                        </div>

                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md">
                            Verify and Claim
                        </button>
                    </form>

                    <!-- Error Message -->
                    @if (isset($errorMessage))
                        <div class="mt-6 text-red-500">
                            <p>{{ $errorMessage }}</p>
                        </div>
                    @endif

                    <!-- QR Code Modal Trigger -->
                    @if (isset($qrCodeText))
                        <div class="mt-6">
                            <h3 class="text-xl">Claim QR Code:</h3>
                            <button onclick="toggleModal()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">
                                View QR Code
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for QR Code -->
    @if (isset($qrCodeText))
        <div id="qrModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-sm mx-auto p-6">
                <h3 class="text-xl font-semibold">Your QR Code</h3>
                <div class="mt-4">
                    <canvas id="qrCodeCanvas" class="mx-auto"></canvas>
                </div>
                <button onclick="downloadQRCode()" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md">
                    Download QR Code
                </button>
                <button onclick="toggleModal()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">
                    Close
                </button>
            </div>
        </div>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script>
        function toggleModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.toggle('hidden');

            if (modal && !modal.classList.contains('hidden')) {
                generateQRCode();
            }
        }

        function generateQRCode() {
            const qrText = @json($qrCodeText ?? '');
            const qr = new QRious({
                element: document.getElementById('qrCodeCanvas'),
                value: qrText,
                size: 200
            });
        }

        function downloadQRCode() {
            const canvas = document.getElementById('qrCodeCanvas');
            const link = document.createElement('a');
            const name = @json($qrCodeName ?? '') + "-be-benz"; // Use name-be-benz format
            link.href = canvas.toDataURL('image/png');
            link.download = name + '.png';
            link.click();
        }
    </script>
</x-home-layout>
