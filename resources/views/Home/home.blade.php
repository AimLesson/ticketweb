<x-home-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div>
                {{-- Title Section --}}
                <div class="flex justify-center">
                    <img src="{{ asset('assets/Asset-23.png') }}" alt="Title Image"
                        class="w-full max-w-3xl object-contain">
                </div>

                {{-- Date Section --}}
                <div class="flex justify-center mt-10">
                    <img src="{{ asset('assets/Asset-26.png') }}" alt="Date Image" class="w-1/2 max-w-xs object-contain">
                </div>

                {{-- Buttons Section --}}
                <div class="flex justify-center space-x-6 mt-10">
                    <button data-modal-target="buy-ticket-modal" data-modal-toggle="buy-ticket-modal"
                        class="w-41 px-8 py-3 bg-amber-400 text-black font-semibold rounded-lg shadow-md hover:bg-amber-500 transition-colors duration-200">
                        BUY TICKETS
                    </button>
                    <a href="#"
                        class="w-41 text-center px-8 py-3 border-2 border-amber-400 text-amber-400 font-semibold rounded-lg hover:bg-amber-400 hover:text-black transition-colors duration-200">
                        FAQ
                    </a>
                </div>
                <!-- Buy Ticket Modal -->
                <div id="buy-ticket-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buy Be-benz Ticket</h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="buy-ticket-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- Modal body -->
                            <form action="{{ route('transaksi.store') }}" method="POST" class="p-4 md:p-5">
                                @csrf
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div>
                                        <label for="nama"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                        <input type="text" id="nama" name="nama"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            required>
                                    </div>
                                    <div>
                                        <label for="alamat"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                        <input type="text" id="alamat" name="alamat"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            required>
                                    </div>
                                    <div>
                                        <label for="nomor_whatsapp"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor
                                            Whatsapp</label>
                                        <input type="text" id="nomor_whatsapp" name="nomor_whatsapp"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            required>
                                    </div>
                                    <div>
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" id="email" name="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            required>
                                    </div>
                                    <div>
                                        <label for="gender"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                        <select id="gender" name="gender"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="nik"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                                        <input type="text" id="nik" name="nik"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            required>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="package"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Package</label>
                                        <select id="package" name="package"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                            <option value="150000">FlashSale-Reg Rp 150.000</option>
                                            <option value="85000">FlashSale-VIP Rp 85.000</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full text-white bg-amber-400 hover:bg-amber-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200">
                                    Pay
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Lineup Section --}}
                <div class="mt-20">
                    {{-- LineUP Title --}}
                    <div class="flex justify-center">
                        <img src="{{ asset('assets/Asset-17.png') }}" alt="Line Up Title Image"
                            class="w-1/2 max-w-xs object-contain">
                    </div>
                    <div class="flex justify-center mb-8">
                        <a href="{{ url('/lineup') }}">
                            <img src="{{ asset('assets/Asset-18.png') }}" alt="Line Up Title Image"
                                class="max-w-32 object-contain">
                        </a>
                    </div>

                    {{-- Lineup Carousel --}}
                    <div class="relative overflow-hidden">
                        {{-- Gradient overlays --}}
                        <div
                            class="absolute left-0 top-0 bottom-0 w-20 bg-gradient-to-r from-white to-transparent z-10">
                        </div>
                        <div
                            class="absolute right-0 top-0 bottom-0 w-20 bg-gradient-to-l from-white to-transparent z-10">
                        </div>

                        {{-- Scrolling container --}}
                        <div class="flex animate-scroll hover:pause">
                            {{-- First set of images --}}
                            <div class="flex space-x-4 shrink-0">
                                <img src="{{ asset('assets/lineup/Asset-59.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-61.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-62.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-60.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-58.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-63.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                            </div>
                            {{-- Duplicate set of images for seamless loop --}}
                            <div class="flex space-x-4 shrink-0">
                                <img src="{{ asset('assets/lineup/Asset-59.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-61.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-62.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-60.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-58.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('assets/lineup/Asset-63.png') }}" alt="Lineup Image"
                                    class="w-72 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tenant Section --}}
                {{-- Tenant Title --}}
                <div class="mt-20">
                    <div class="flex justify-center">
                        <img src="{{ asset('assets/tenant/Asset-72.png') }}" alt="Line Up Title Image"
                            class="max-w-lg w-1/2 object-contain">
                    </div>
                    <div class="flex justify-center mt-4 gap-4 flex-wrap">
                        <img src="{{ asset('assets/tenant/Asset-76.png') }}" alt="Lineup Image"
                            class="w-72 sm:w-80 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('assets/tenant/Asset-74.png') }}" alt="Lineup Image"
                            class="w-72 sm:w-80 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('assets/tenant/Asset-75.png') }}" alt="Lineup Image"
                            class="w-72 sm:w-80 md:w-96 object-cover rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
                

                {{-- Title Section --}}
                <div class="relative flex justify-center mt-20">
                    <button data-modal-target="buy-ticket-modal" data-modal-toggle="buy-ticket-modal"
                        class="absolute bottom-40 w-41 px-8 py-3 bg-amber-400 text-black font-semibold rounded-lg shadow-md hover:bg-amber-500 transition-colors duration-200 z-10">
                        BUY TICKETS
                    </button>
                    <img src="{{ asset('assets/Asset-84.png') }}" alt="Funrun Image"
                        class="w-full max-w-3xl object-contain">
                </div>

            </div>
        </div>
    </div>
</x-home-layout>
