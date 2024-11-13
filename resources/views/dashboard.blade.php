<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">NIK</th>
                                <th scope="col" class="px-6 py-3">Address</th>
                                <th scope="col" class="px-6 py-3">Nomor Handphone</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Gender</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Bukti Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $transaksiItem)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $transaksiItem->nama }}
                                    </td>
                                    <td class="px-6 py-4">{{ $transaksiItem->nik }}</td>
                                    <td class="px-6 py-4">{{ $transaksiItem->alamat }}</td>
                                    <td class="px-6 py-4">{{ $transaksiItem->nomor_whatsapp }}</td>
                                    <td class="px-6 py-4">{{ $transaksiItem->email }}</td>
                                    <td class="px-6 py-4">{{ $transaksiItem->gender }}</td>
                                    <td class="px-6 py-4">
                                        <select class="status-dropdown" data-id="{{ $transaksiItem->id }}" 
                                                {{ $transaksiItem->status === 'paid' ? 'disabled' : '' }}>
                                            <option value="pending" {{ $transaksiItem->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $transaksiItem->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="shipped" {{ $transaksiItem->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="completed" {{ $transaksiItem->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($transaksiItem->picture)
                                            <img src="{{ asset('storage/' . $transaksiItem->picture) }}" alt="Picture" class="w-16 h-16 object-cover rounded cursor-pointer" onclick="openModal('{{ asset('storage/' . $transaksiItem->picture) }}')">
                                        @else
                                            <span>No Picture</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="pictureModal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto mx-auto">
            <div class="relative bg-white rounded-lg shadow-lg">
                <div class="flex justify-between items-start p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Picture</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="closeModal()">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 7.586l4.293-4.293a1 1 0 111.414 1.414L11.414 9l4.293 4.293a1 1 0 01-1.414 1.414L10 10.414l-4.293 4.293a1 1 0 11-1.414-1.414L8.586 9 4.293 4.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <img id="modalImage" src="" alt="Picture" class="w-full h-auto rounded-lg">
                    <div class="mt-4 text-center">
                        <a id="downloadLink" href="#" class="inline-block px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-lg" download>Download Image</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to open the modal and set the image source and download link
        function openModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('downloadLink').href = imageUrl;
            document.getElementById('pictureModal').classList.remove('hidden');
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('pictureModal').classList.add('hidden');
        }

        // Listen for changes in the status dropdown
        document.querySelectorAll('.status-dropdown').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const status = this.value;
                const id = this.getAttribute('data-id');
                const phoneNumber = this.closest('tr').querySelector('td:nth-child(4)').innerText; // User's phone number

                // Send AJAX request to update the status
                fetch(`/transaksi/update-status/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // If the status is set to 'paid', send confirmation to user via WhatsApp
                        if (status === 'paid') {
                            sendWA(phoneNumber, 'Pembayaran Anda telah diterima. Terima kasih!');
                        }

                        // Success notification using SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated!',
                            text: data.message || 'The status has been updated successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        // Error notification using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message || 'Failed to update the status.',
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // General error notification using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the status.',
                        showConfirmButton: true
                    });
                });
            });
        });

        // Function to send a WhatsApp message
        function sendWA(phoneNumber, message) {
            fetch(`/transaksi/send-wa`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    phone_number: phoneNumber,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Failed to send WhatsApp message');
                }
            })
            .catch(error => console.error('Error sending WhatsApp message:', error));
        }
    </script>
</x-app-layout>
