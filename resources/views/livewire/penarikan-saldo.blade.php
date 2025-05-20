<div x-data="{ openModal: false }" class="flex justify-center bg-gray-200 min-h-full min-w-full">
    <div class="py-8 w-4/5 mx-auto">


        <div class="flex justify-between items-center mb-6">
            <div class="w-1/3">
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

            <div class="flex flex-col gap-2 items-end">

                <div class="flex items-center">
                    <span class="mr-2 text-sm text-gray-600">Status:</span>
                    <div x-data="{
                        openStatusFilter: false,
                        selected: @entangle('status'),
                        options: {
                            '': 'Semua status',
                            pending: 'Pending',
                            completed: 'Selesai',
                            rejected: 'Ditolak',
                        }
                    }" class="relative w-52">

                        <!-- Dropdown Trigger -->
                        <div @click="openStatusFilter = !openStatusFilter"
                            class="flex justify-between items-center w-full px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                            :class="{ 'ring-2 ring-emerald-400': openStatusFilter }">
                            <span class="truncate mr-2" x-text="options[selected] || 'Filter berdasar status'"></span>
                            <svg class="w-4 h-4 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Dropdown Options -->
                        <div x-show="openStatusFilter" @click.away="openStatusFilter = false" x-transition
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                            <template x-for="(label, value) in options" :key="value">
                                <div @click="openStatusFilter = false; $wire.set('status', value)"
                                    class="px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                    <span x-text="label"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
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
                    }" class="relative w-52">

                        <!-- Dropdown Trigger -->
                        <div @click="openTimeFilter = !openTimeFilter"
                            class="flex justify-between items-center w-full px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                            :class="{ 'ring-2 ring-emerald-400': openTimeFilter }">
                            <span class="truncate mr-2" x-text="options[selected] || 'Filter berdasar waktu'"></span>
                            <svg class="w-4 h-4 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
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
            </div>



        </div>

        <!-- Tabel -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mx-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed">
            <thead class="bg-gray-50">
                <tr>
                <th scope="col"
                    class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    wire:click="sortBy('created_at')">
                    <div class="flex items-center">
                    Tanggal
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
                    class="w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nasabah
                    </th>
                @endif

                <th scope="col"
                    class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No. E-wallet
                </th>

                <th scope="col"
                    class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    E-wallet
                </th>

                <th scope="col"
                    class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    wire:click="sortBy('jumlah')">
                    <div class="flex items-center">
                    Jumlah
                    <span class="ml-1">
                        @if ($sortField === 'jumlah')
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
                    class="w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    wire:click="sortBy('status')">
                    <div class="flex items-center">
                    Status
                    <span class="ml-1">
                        @if ($sortField === 'status')
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

                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($riwayat as $item)
                <tr wire:key="{{ $item->id }}" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $item->created_at->format('M d, Y') }}</div>
                    </td>
                    @if (auth()->user()->role === 'admin')
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 truncate max-w-[200px]">
                        {{ $item->nasabah->nama_depan . ' ' . $item->nasabah->nama_belakang }}</div>
                    </td>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 truncate">
                        {{ $item->no_telepon }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                    <img src="{{ $item->metode_pembayaran === 'LinkAja' ? '/assets/linkaja.png' : '/assets//' . strtolower($item->metode_pembayaran) . '.svg' }}"
                        alt="{{ $item->metode_pembayaran }}" class="max-h-8 max-w-16 object-contain">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex justify-center">
                        @switch($item->status)
                        @case('pending')
                            <span wire:click="seeDetail({{ $item->id }})" @click="openModal = true"
                            class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-medium 
                            hover:bg-yellow-200 cursor-pointer transition-colors duration-200 
                            hover:shadow-sm inline-flex items-center">
                            <span>Pending</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 ml-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            </span>
                        @break

                        @case('completed')
                            <span wire:click="seeDetail({{ $item->id }})" @click="openModal = true"
                            class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium 
                            hover:bg-green-200 cursor-pointer transition-colors duration-200 
                            hover:shadow-sm inline-flex items-center">
                            <span>Selesai</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 ml-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            </span>
                        @break

                        @case('rejected')
                            <span wire:click="seeDetail({{ $item->id }})" @click="openModal = true"
                            class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800 font-medium 
                            hover:bg-red-200 cursor-pointer transition-colors duration-200 
                            hover:shadow-sm inline-flex items-center">
                            <span>Ditolak</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 ml-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            </span>
                        @break

                        @default
                            <span wire:click="seeDetail({{ $item->id }})" @click="openModal = true"
                            class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800 font-medium 
                            hover:bg-gray-200 cursor-pointer transition-colors duration-200 
                            hover:shadow-sm inline-flex items-center">
                            <span>{{ ucfirst(strtolower($item->status)) }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 ml-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            </span>
                        @endswitch
                    </div>
                    </td>
                </tr>
                @empty
                    <tr>
                    <td colspan="{{ auth()->user()?->role === 'admin' ? '6' : '5' }}"
                        class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Tidak ada data penarikan</p>
                        </div>
                    </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                {{ $riwayat->links() }}
            </div>
            </div>
        </div>

        <div x-cloak x-show="openModal" class="fixed inset-0 bg-black/50 z-50" x.transition.opacity></div>


        <div x-cloak x-show="openModal"
            class="fixed flex flex-col w-11/12 md:w-4/5 lg:w-[70vw] max-h-[90vh] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-4 md:p-6 z-50 overflow-hidden"
            @click.away="openModal = false" x-transition>

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Penarikan</h2>

            <div class="overflow-y-auto flex-1">
                <div wire:loading wire:target="seeDetail"
                    class="min-w-full flex-1 flex items-center justify-center py-12">
                    <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-500 mb-3 animate-spin"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <p class="text-gray-600 text-lg font-medium">Memuat data penarikan...</p>
                    </div>
                </div>

                <div wire:loading.remove wire:target="seeDetail">
                    @if ($penarikan)
                        <div class="bg-gray-50 rounded-lg p-4 mb-5">
                            <div class="flex flex-col md:flex-row justify-between">
                                <!-- User profile information -->
                                <div class="flex items-center mb-4 md:mb-0">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset($penarikan->nasabah->avatar_url) }}"
                                            alt="Avatar {{ $penarikan->nasabah->nama_depan }}"
                                            class="h-16 w-16 rounded-full object-cover border-2 border-emerald-500">
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-800">
                                            {{ $penarikan->nasabah->nama_depan }}
                                            {{ $penarikan->nasabah->nama_belakang }}</h3>
                                        <p class="text-sm text-gray-500">No. Telp: {{ $penarikan->nasabah->no_telepon }}
                                        </p>
                                        <p class="text-sm font-medium text-emerald-600">Saldo: Rp
                                            {{ number_format($penarikan->nasabah->profile->saldo, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Transaction details -->
                                <div class="flex flex-wrap justify-between gap-4 md:gap-6">
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal & Waktu</p>
                                        <p class="font-medium">{{ $penarikan->created_at->format('H:i, d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Jumlah Penarikan</p>
                                        <p class="font-medium text-emerald-600">Rp
                                            {{ number_format($penarikan->jumlah, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Status</p>
                                        <div class="mt-1">
                                            @switch($penarikan->status)
                                                @case('pending')
                                                    <span
                                                        class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-medium">
                                                        Pending
                                                    </span>
                                                @break

                                                @case('completed')
                                                    <span
                                                        class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">
                                                        Selesai
                                                    </span>
                                                @break

                                                @case('rejected')
                                                    <span
                                                        class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800 font-medium">
                                                        Ditolak
                                                    </span>
                                                @break

                                                @default
                                                    <span
                                                        class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800 font-medium">
                                                        {{ ucfirst(strtolower($penarikan->status)) }}
                                                    </span>
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                            <h3 class="font-medium text-gray-700 mb-3">Informasi Penarikan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Metode Pembayaran</p>
                                    <div class="flex items-center mt-1">
                                        <img src="{{ $penarikan->metode_pembayaran === 'LinkAja' ? '/assets/linkaja.png' : '/assets//' . strtolower($penarikan->metode_pembayaran) . '.svg' }}"
                                            alt="{{ $penarikan->metode_pembayaran }}" class="h-8 w-auto mr-2">
                                        <p class="font-medium">{{ $penarikan->metode_pembayaran }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Nomor E-wallet</p>
                                    <p class="font-medium mt-1">{{ $penarikan->no_telepon }}</p>
                                </div>
                            </div>
                        </div>

                        @if (auth()->user()->role === 'admin' && $penarikan->status === 'pending')
                            <div x-data="{ showRejectConfirm: false, showApproveConfirm: false }" class="mt-6">
                                <!-- Confirmation Messages -->
                                <div x-cloak x-show="showRejectConfirm"
                                    class="bg-red-50 p-4 rounded-lg mb-4 border border-gray-300">
                                    <h3 class="text-md font-semibold mb-2">Konfirmasi Penolakan</h3>
                                    <p class="mb-4 text-sm text-gray-700">Apakah Anda yakin ingin menolak permintaan
                                        penarikan saldo ini?</p>

                                    <div class="flex justify-end space-x-3">
                                        <button type="button"
                                            class="px-3 py-1 text-sm hover:cursor-pointer rounded bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold"
                                            @click="showRejectConfirm = false">
                                            Batal
                                        </button>
                                        <button type="button"
                                            class="px-3 py-1 text-sm hover:cursor-pointer rounded bg-red-600 hover:bg-red-700 text-white font-semibold"
                                            wire:click="rejectWithdraw({{ $penarikan->id }})" @click="openModal = false">
                                            Tolak
                                        </button>
                                    </div>
                                </div>

                                <div x-cloak x-show="showApproveConfirm"
                                    class="bg-green-50 p-4 rounded-lg mb-4 border border-gray-300">
                                    <h3 class="text-md font-semibold mb-2">Konfirmasi Penyelesaian</h3>
                                    <p class="mb-4 text-sm text-gray-700">Apakah Anda yakin ingin menyelesaikan penarikan
                                        dari nasabah {{ $penarikan->nasabah->nama_depan }}
                                        {{ $penarikan->nasabah->nama_belakang }}? Pastikan Anda telah memeriksa dengan
                                        cermat dan telah mengirimkan uang kepada akun e-wallet nasabah. Karena saldo nasabah
                                        akan dikurangi ketika Anda menyelesaikannya.</p>

                                    <div class="flex justify-end space-x-3">
                                        <button type="button"
                                            class="px-3 py-1 text-sm hover:cursor-pointer rounded bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold"
                                            @click="showApproveConfirm = false">
                                            Batal
                                        </button>
                                        <button type="button"
                                            class="px-3 py-1 text-sm hover:cursor-pointer rounded bg-emerald-600 hover:bg-emerald-700 text-white font-semibold"
                                            wire:click="approveWithdraw({{ $penarikan->id }})"
                                            @click="openModal = false">
                                            Selesaikan
                                        </button>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div x-show="!showRejectConfirm && !showApproveConfirm"
                                    class="flex flex-col sm:flex-row sm:justify-end gap-3">
                                    <button type="button" @click="showRejectConfirm = true;"
                                        class="flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 hover:cursor-pointer transition duration-200 font-medium">
                                        Tolak Penarikan
                                    </button>
                                    <button type="button" @click="showApproveConfirm = true;"
                                        class="flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 hover:cursor-pointer transition duration-200 font-medium">
                                        Selesaikan Penarikan
                                    </button>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500 text-lg">Data tidak ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    </div>
