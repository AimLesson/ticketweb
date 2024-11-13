<x-home-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            {{-- Title --}}
            <h2 class="text-2xl font-semibold mb-6">Payment via QRIS</h2>

            {{-- QRIS Modal Trigger --}}
            <button data-modal-target="qris-modal" data-modal-toggle="qris-modal"
                class="px-8 py-3 bg-amber-400 text-black font-semibold rounded-lg shadow-md hover:bg-amber-500 transition-colors duration-200">
                View QRIS
            </button>

            {{-- QRIS Modal --}}
            <div id="qris-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        {{-- Modal Header --}}
                        <div class="flex items-center justify-between p-4 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">QRIS Payment</h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                data-modal-toggle="qris-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>

                        {{-- Modal Body --}}
                        <div class="p-4 text-center">
                            <img src="{{ asset('assets/qris.jpg') }}" alt="QRIS Code" class="w-64 mx-auto">
                            <a href="{{ asset('assets/qris.jpg') }}" download="qris.png"
                                class="mt-4 inline-block px-6 py-2 bg-amber-400 text-white font-semibold rounded-lg hover:bg-amber-500 transition-colors duration-200">
                                Download QRIS
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative bg-white rounded-lg shadow">
                {{-- Input Form --}}
                <form id="verification-form" enctype="multipart/form-data" class="mt-8 p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div>
                            <label for="nama"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                            <input type="text" id="nama" name="nama"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 ">
                        </div>
                        <div>
                            <label for="nik"
                                class="block mb-2 text-sm font-medium text-gray-900 ">NIK</label>
                            <input type="text" id="nik" name="nik"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 ">
                        </div>
                        <div>
                            <label for="package"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Package
                                Price</label>
                            <input type="text" id="package-price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 "
                                disabled placeholder="Klik Disini Setelah Memasukan Data Diri">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 "
                                for="file_input">Upload
                                file</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                type="file" id="file-upload" name="file" disabled>
                        </div>
                    </div>
                    <button type="button" onclick="submitForm()"
                        class="px-8 py-3 bg-amber-400 text-black font-semibold rounded-lg shadow-md hover:bg-amber-500 transition-colors duration-200">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('nik').addEventListener('blur', function () {
            const nama = document.getElementById('nama').value;
            const nik = this.value;

            if (nama && nik.length === 16) {
                fetch(`/verify-transaction?nama=${nama}&nik=${nik}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('package-price').value = `Rp ${data.price}`;
                            document.getElementById('file-upload').disabled = false;
                        } else {
                            Swal.fire('Error', 'Pastikan Nama dan NIK sesuai pada saat pembelian Paket', 'error');
                        }
                    });
            }
        });

        function submitForm() {
            const form = document.getElementById('verification-form');
            const formData = new FormData(form);

            fetch('/pay/upload', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terikirim',
                        text: 'Bukti Pembayaran Terikirim Silahkan Tunggu Verifikasi',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Pastikan Nama dan NIK sesuai pada saat pembelian Paket',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                });
            });
        }
    </script>
</x-home-layout>
