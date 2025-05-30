<div x-data="{ openModal: false }" class="flex justify-center bg-gradient-to-b from-emerald-50 to-emerald-200 min-h-full min-w-full">
    <div class="py-8 w-full sm:w-11/12 md:w-10/12 lg:w-4/5 mx-auto px-4 sm:px-6">


        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <div class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="term"
                        class="bg-white w-full pl-10 pr-4 py-2 rounded-lg border drop-shadow-sm border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition duration-300"
                        placeholder="Cari transaksi...">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-0">
                <span class="mr-2 text-sm text-gray-600">Filter berdasarkan waktu:</span>
                <div x-data="{
                    openTimeFilter: false,
                    selected: @entangle('dateFilter'),
                    options: {
                        '': 'Semua waktu',
                        today: 'Hari ini',
                        week: 'Seminggu terakhir',
                        month: 'Sebulan terakhir',
                        year: 'Setahun terakhir',
                    }
                }" class="relative w-full sm:w-52">
    
                    <!-- Dropdown Trigger -->
                    <div @click="openTimeFilter = !openTimeFilter"
                        class="flex justify-between items-center w-full px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                        :class="{ 'ring-2 ring-emerald-400': openTimeFilter }">
                        <span class="truncate mr-2" x-text="options[selected] || 'Filter berdasar waktu'"></span>
                        <svg class="w-4 h-4 flex-shrink-0 text-gray-600" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
    
                    <!-- Dropdown Options -->
                    <div x-show="openTimeFilter" @click.away="openTimeFilter = false" x-transition
                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                        <template x-for="(label, value) in options" :key="value">
                            <div @click="openTimeFilter = false; $wire.set('dateFilter', value)"
                                class="px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                <span x-text="label"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role === 'admin')
                <div class="mt-3 md:mt-0">
                    <a href="{{ route('admin.dashboard.setoran.create') }}" wire:navigate
                        class="bg-emerald-600 hover:bg-emerald-700 drop-shadow-md hover:cursor-pointer text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center md:justify-start transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Setoran
                    </a>
                </div>
            @endif

        </div>

        <!-- Tabel -->
        <div class="bg-white rounded-lg shadow-md overflow-x-auto mx-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="w-24 px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('created_at')">
                            <div class="flex items-center">
                                <span class="hidden sm:inline">Tanggal</span>
                                <span class="sm:hidden">Tgl</span>
                                <span class="ml-1">
                                    @if ($sortField === 'created_at')
                                        @if ($sortDirection === 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    @endif
                                </span>
                            </div>
                        </th>

                        @if (auth()->user()->role === 'admin')
                            <th scope="col"
                                class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="hidden sm:inline">Nasabah</span>
                                <span class="sm:hidden">Nsb</span>
                            </th>
                        @endif

                        <th scope="col"
                            class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('total_berat')">
                            <div class="flex items-center">
                                <span class="hidden sm:inline">Berat</span>
                                <span class="sm:hidden">Brt</span>
                                <span class="ml-1">
                                    @if ($sortField === 'total_berat')
                                        @if ($sortDirection === 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    @endif
                                </span>
                            </div>
                        </th>

                        <th scope="col"
                            class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('total_harga')">
                            <div class="flex items-center">
                                <span class="hidden sm:inline">Jumlah</span>
                                <span class="sm:hidden">Jml</span>
                                <span class="ml-1">
                                    @if ($sortField === 'total_harga')
                                        @if ($sortDirection === 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    @endif
                                </span>
                            </div>
                        </th>

                        <th scope="col"
                            class="w-16 sm:w-24 px-3 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($riwayat as $item)
                        <tr wire:key="{{ $item->id }}" class="hover:bg-gray-50">
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm text-gray-900">{{ $item->created_at->format('M d, Y') }}</div>
                            </td>
                            @if (auth()->user()->role === 'admin')
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        <span class="hidden sm:inline">
                                            {{ $item->nasabah->nama_depan . ' ' . $item->nasabah->nama_belakang }}
                                        </span>
                                        <span class="sm:hidden">
                                            {{ $item->nasabah->nama_depan }}
                                        </span>
                                    </div>
                                </td>
                            @endif
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm text-gray-900">
                                    {{ number_format($item->total_berat, 2, ',', '.') . ' kg' }}</div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm text-gray-900">Rp
                                    {{ number_format($item->total_harga, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap flex justify-center">
                                <button type="button" wire:click="seeDetail({{ $item->id }})"
                                    @click="openModal = true"
                                    class="text-xs p-1.5 sm:p-2 border border-emerald-600 bg-white text-emerald-600 rounded-md hover:bg-emerald-600 hover:text-white hover:cursor-pointer transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()?->role === 'admin' ? '5' : '4' }}"
                                class="px-3 sm:px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p>Tidak ada data transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-3 sm:px-6 py-3 bg-gray-50 border-t border-gray-200 overflow-x-auto">
                {{ $riwayat->links() }}
            </div>
        </div>
    </div>

    <div x-cloak x-show="openModal" class="fixed inset-0 bg-black/50 z-50" x.transition.opacity></div>


    <div x-cloak x-show="openModal"
        class="fixed flex flex-col w-11/12 md:w-4/5 lg:w-[70vw] max-h-[90vh] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-3 sm:p-4 md:p-6 z-50 overflow-hidden"
        @click.away="openModal = false" x-transition>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Detail Transaksi</h2>
            <button @click="openModal = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="overflow-y-auto flex-1">
            <div wire:loading wire:target="seeDetail"
                class="min-w-full flex-1 flex items-center justify-center py-12">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-500 mb-3 animate-spin"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <p class="text-gray-600 text-lg font-medium">Memuat data transaksi...</p>
                </div>
            </div>

            <div wire:loading.remove wire:target="seeDetail">
                @if ($transaksi)
                    <div class="bg-gray-50 rounded-lg p-3 sm:p-4 mb-5 flex flex-col md:flex-row justify-between gap-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ asset($transaksi->nasabah->avatar_url) }}"
                                    alt="Avatar {{ $transaksi->nasabah->nama_depan }}"
                                    class="h-12 w-12 sm:h-16 sm:w-16 rounded-full object-cover border-2 border-emerald-500">
                            </div>
                            <div class="ml-3 sm:ml-4">
                                <h3 class="text-base sm:text-lg font-medium text-gray-800">{{ $transaksi->nasabah->nama_depan }}
                                    {{ $transaksi->nasabah->nama_belakang }}</h3>
                                <p class="text-xs sm:text-sm text-gray-500">No. Telp: {{ $transaksi->nasabah->no_telepon }}</p>
                            </div>
                        </div>

                        <div class="md:ml-6 flex items-center flex-wrap gap-x-4 sm:gap-x-6 gap-y-2 mt-3 md:mt-0">
                            <div>
                                <p class="text-xs text-gray-500">Tanggal & Waktu</p>
                                <p class="text-xs sm:text-sm font-medium">{{ $transaksi->created_at->format('H:i, d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Total Berat</p>
                                <p class="text-xs sm:text-sm font-medium">{{ number_format($transaksi->total_berat, 2, ',', '.') }} kg
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Total Harga</p>
                                <p class="text-xs sm:text-sm font-medium text-emerald-600">Rp
                                    {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="text-left py-2 sm:py-3 px-2 sm:px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sampah</th>
                                    <th
                                        class="text-left py-2 sm:py-3 px-2 sm:px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Berat (kg)</th>
                                    <th
                                        class="text-left py-2 sm:py-3 px-2 sm:px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga/kg</th>
                                    <th
                                        class="text-left py-2 sm:py-3 px-2 sm:px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if (isset($transaksi->sampah) && count($transaksi->sampah) > 0)
                                    @foreach ($transaksi->sampah as $sampah)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-2 sm:py-3 px-2 sm:px-4 text-xs sm:text-sm">{{ $sampah->nama }}</td>
                                            <td class="py-2 sm:py-3 px-2 sm:px-4 text-xs sm:text-sm">
                                                {{ number_format($sampah->pivot->berat, 2, ',', '.') }}</td>
                                            <td class="py-2 sm:py-3 px-2 sm:px-4 text-xs sm:text-sm">Rp
                                                {{ number_format($sampah->harga_per_kg, 0, ',', '.') }}</td>
                                            <td class="py-2 sm:py-3 px-2 sm:px-4 text-xs sm:text-sm font-medium">Rp
                                                {{ number_format($sampah->pivot->harga_subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 border-t-2 border-gray-200">
                                        <td colspan="2"
                                            class="py-2 sm:py-3 px-2 sm:px-4 text-xs sm:text-sm font-medium text-gray-700 text-right">
                                            TOTAL:</td>
                                        <td class="py-2 sm:py-3 px-2 sm:px-4 text-xs sm:text-sm font-medium text-gray-700">
                                            {{ number_format($transaksi->total_berat, 2, ',', '.') }} kg</td>
                                        <td class="py-2 sm:py-3 px-2 sm:px-4 text-xs sm:text-sm font-bold text-emerald-600">Rp
                                            {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-500">Tidak ada data
                                            sampah
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-xs text-gray-500 text-right italic">
                        Update terakhir: {{ $transaksi->updated_at->diffForHumans() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 text-lg">Data transaksi tidak ditemukan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
