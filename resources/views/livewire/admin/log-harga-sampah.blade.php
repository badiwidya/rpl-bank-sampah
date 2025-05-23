<div class="flex justify-center bg-gradient-to-b from-emerald-50 to-emerald-200 min-h-full min-w-full">
    <div class="py-4 sm:py-6 md:py-8 w-full sm:w-11/12 md:w-4/5 mx-auto px-3 sm:px-0">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0 mb-4 sm:mb-6">
            <div class="w-full sm:w-1/2">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="term"
                        class="bg-white w-full pl-8 sm:pl-10 pr-3 sm:pr-4 py-2 rounded-lg border drop-shadow-sm border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition duration-300"
                        placeholder="Cari sampah...">
                    <div class="absolute left-2.5 sm:left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.dashboard.sampah') }}" wire:navigate
                class="bg-emerald-600 hover:bg-emerald-700 drop-shadow-md hover:cursor-pointer text-white font-medium py-1.5 sm:py-2 px-3 sm:px-4 text-sm sm:text-base rounded-lg flex items-center transition duration-150 ease-in-out mt-2 sm:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1.5 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Kembali Lihat Katalog Sampah
            </a>
        </div>        
        <div class="bg-white rounded-lg shadow-md overflow-hidden overflow-x-auto mx-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('sampah_id')">
                            <div class="flex items-center">
                                <span class="truncate">Nama Sampah</span>
                                <span class="ml-1">
                                    @if ($sortField === 'sampah_id')
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
                                    @endif
                                </span>
                            </div>
                        </th>

                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('harga_lama')">
                            <div class="flex items-center">
                                <span class="truncate">Harga Lama</span>
                                <span class="ml-1">
                                    @if ($sortField === 'harga_lama')
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
                                    @endif
                                </span>
                            </div>
                        </th>

                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('harga_baru')">
                            <div class="flex items-center">
                                <span class="truncate">Harga Baru</span>
                                <span class="ml-1">
                                    @if ($sortField === 'harga_baru')
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
                                    @endif
                                </span>
                            </div>
                        </th>

                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hidden sm:table-cell"
                            wire:click="sortBy('user_id')">
                            <div class="flex items-center">
                                <span class="truncate">Diubah Oleh</span>
                                <span class="ml-1">
                                    @if ($sortField === 'user_id')
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
                                    @endif
                                </span>
                            </div>
                        </th>

                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hidden sm:table-cell"
                            wire:click="sortBy('created_at')">
                            <div class="flex items-center">
                                <span class="truncate">Tanggal Perubahan</span>
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
                                    @endif
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                {{ $log->sampah->nama }}
                            </td>
                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                Rp {{ number_format($log->harga_lama, 0, ',', '.') }}
                            </td>
                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                Rp {{ number_format($log->harga_baru, 0, ',', '.') }}
                                <div class="mt-1 text-xs text-gray-400 sm:hidden">
                                    <div>Oleh: {{ $log->admin->nama_depan }} {{ $log->admin->nama_belakang }}</div>
                                    <div>{{ $log->created_at->format('d/m/Y') }}</div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden sm:table-cell">
                                {{ $log->admin->nama_depan }} {{ $log->admin->nama_belakang }}
                            </td>
                            <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden sm:table-cell">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs sm:text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center py-4 sm:py-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-12 sm:w-12 text-gray-400 mb-1 sm:mb-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-xs sm:text-sm font-medium">Belum ada data log perubahan harga</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 sm:mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
