<div class="h-full flex flex-col w-full p-6 bg-gradient-to-b from-emerald-50 to-emerald-300">
    <div x-data="greetingHandler()" x-init="updateGreeting();
    setInterval(updateGreeting, 60000)" class="mb-8">
        <h1 class="text-3xl text-gray-800 font-light">Selamat <span x-text="greeting"></span>,
            <span class="font-semibold text-emerald-600">{{ $user->nama_depan }}</span>!
        </h1>
    </div>

    <div class="grid flex-1 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card Statistik -->
        <div
            class="bg-white flex flex-col justify-between rounded-lg shadow-lg hover:scale-103 transition duration-300 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-600">Total Nasabah</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="text-2xl font-bold">{{ $nasabahTotal }}</div>
        </div>

        <div
            class="bg-white flex flex-col justify-between rounded-lg shadow-lg hover:scale-103 transition duration-300 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-600">Total Sampah (kg)</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
            </div>
            <div class="text-2xl font-bold">{{ $sampahTotal }}</div>
        </div>

        <div
            class="bg-white flex flex-col justify-between rounded-lg shadow-lg hover:scale-103 transition duration-300 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-600">Setoran Bulan Ini</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="text-2xl font-bold">{{ $setoranBulanIni }}</div>
        </div>
    </div>

    <!-- Grafik & Tabel -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-600">Transaksi Sampah Terkini</h2>
                <a href="{{ route('admin.dashboard.setoran') }}"
                    class="flex gap-2 py-1 px-4 bg-emerald-600 rounded text-white hover:bg-emerald-700 hover:cursor-pointer text-md transition duration-400"
                    wire:navigate>
                    Lihat Detail
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nasabah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Berat (kg)</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($setoranSampahTerkini as $transaksi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaksi->created_at->format('d/m/y') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaksi->nasabah->nama_depan }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($transaksi->total_berat, 1, ',', '.') }} kg</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Rp
                                    {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-500">Belum ada
                                    transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white col-span-2 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-600">Penarikan Dengan Status Pending</h2>
                <a href="{{ route('admin.dashboard.setoran') }}"
                    class="flex gap-2 py-1 px-4 bg-emerald-600 rounded text-white hover:bg-emerald-700 hover:cursor-pointer text-md transition duration-400"
                    wire:navigate>
                    Lihat Detail
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nasabah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                E-wallet</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permintaanPenarikanPending as $penarikan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $penarikan->created_at->format('d/m/y') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $penarikan->nasabah->nama_depan }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $penarikan->metode_pembayaran }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Rp
                                    {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-500">Tidak ada
                                    permintaan penarikan pending</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function greetingHandler() {
                return {
                    greeting: '',
                    updateGreeting() {
                        const hour = new Date().getHours()

                        if (hour >= 4 && hour < 10) {
                            this.greeting = 'pagi';
                        } else if (hour >= 10 && hour < 15) {
                            this.greeting = 'siang';
                        } else if (hour >= 15 && hour < 18) {
                            this.greeting = 'sore';
                        } else {
                            this.greeting = 'malam';
                        }
                    }
                }
            }
        </script>
    @endpush
</div>
