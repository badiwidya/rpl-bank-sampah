<div x-data="{ openModal: false }"
    class="bg-gradient-to-b from-emerald-50 to-emerald-200 min-h-full min-w-full flex justify-center items-center p-3 sm:p-4 md:p-6">
    <div
        class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-4 sm:p-6 md:p-8 rounded-lg sm:rounded-xl shadow-xl w-full max-w-full sm:max-w-[80%] md:max-w-[70%] lg:max-w-[60%]">

        <div x-data="{ open: @entangle('isUserSelected') }" class="flex flex-col sm:flex-row justify-between gap-3 mb-4 sm:mb-6">
            <h1 class="text-lg sm:text-xl font-semibold mb-2 sm:mb-0">Buat Setoran Baru</h1>
            <div x-show="open" x-cloak class="flex gap-2 items-center max-w-full sm:max-w-[30%]">
                <div
                    class="h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 rounded-full border-1 border-gray-400 overflow-hidden">
                    <img src="{{ asset($selectedUser?->avatar_url) }}"
                        alt="{{ $selectedUser?->nama_depan . '\'s profile picture' }}"
                        class="object-cover w-full h-full">
                </div>
                <div class="flex flex-col overflow-hidden">
                    <p class="text-xs sm:text-sm truncate whitespace-nowrap text-ellipsis overflow-hidden">
                        {{ $selectedUser?->nama_depan . ' ' . $selectedUser?->nama_belakang }}</p>
                    <p class="text-xs text-gray-600 truncate whitespace-nowrap text-ellipsis overflow-hidden">
                        {{ $selectedUser?->email }}</p>
                </div>
            </div>
        </div>


        <div class="relative w-full sm:w-[70%] md:w-[60%] lg:w-[50%]" x-data="{ open: false }"
            @click.away="open = false">
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nomor Telepon Nasabah</label>

            <input type="text" wire:model.live.debounce.100ms="searchUser" @focus="open = true"
                placeholder="Ketik nomor telepon..."
                class="w-full px-3 sm:px-4 py-1.5 sm:py-2 border border-gray-300 rounded-md text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300">

            <div x-show="open" x-cloak x-transition
                class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-40 sm:max-h-60 overflow-y-auto">
                @forelse($this->filteredUsers() as $user)
                    <div wire:click="selectUser('{{ $user->no_telepon }}')" @click="open = false"
                        class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-emerald-100 cursor-pointer transition">
                        {{ $user->nama_depan . ' ' . $user->nama_belakang }} - {{ $user->no_telepon }}
                    </div>
                @empty
                    <div class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-500">Tidak ditemukan</div>
                @endforelse
            </div>
        </div>

        <div
            class="self-center p-3 sm:p-4 mt-3 sm:mt-4 rounded-md flex flex-col w-full sm:w-[90%] md:w-[85%] lg:w-[80%] justify-center">

            <button type="button" @click="openModal = true"
                class="mb-3 sm:mb-4 w-full py-1.5 sm:py-2 text-white text-xs sm:text-sm bg-emerald-600 rounded-md hover:bg-emerald-700 hover:cursor-pointer transition-colors duration-300">Pilih
                Sampah</button>

            <div
                class="flex flex-col items-start border border-gray-300 rounded-md h-[150px] sm:h-[180px] md:h-[200px] overflow-y-auto mb-3 sm:mb-4">
                @forelse ($selectedSampah as $id => $data)
                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between p-2 border border-gray-100 rounded-lg shadow-sm w-full hover:bg-gray-50 transition-all duration-200 mb-2 gap-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <img src="{{ asset($data['gambar']) }}" alt="{{ $data['nama'] }}"
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 object-cover rounded-md shadow-sm">
                            <div>
                                <div class="font-medium text-xs sm:text-sm text-gray-800 truncate">{{ $data['nama'] }}
                                </div>
                                <div class="text-xs text-emerald-600 font-semibold">
                                    Rp{{ number_format((float) $data['harga_per_kg'] * ((float) ($selectedSampah[$id]['berat'] ?? 0)), 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3 mt-2 sm:mt-0">
                            <div class="relative">
                                <input type="number" step="0.01" min="0"
                                    wire:model.lazy="selectedSampah.{{ $id }}.berat"
                                    class="border border-gray-300 text-xs sm:text-sm px-2 sm:px-3 py-1 sm:py-1.5 pr-8 sm:pr-10 rounded-md w-28 sm:w-36 md:w-48 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition"
                                    placeholder="Berat (kg)">
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-2 sm:pr-3 pointer-events-none text-gray-500 text-xs sm:text-sm font-medium">
                                    kg
                                </div>
                            </div>
                            <button type="button" wire:click="removeSampah({{ $id }})"
                                class="flex items-center justify-center w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col w-full h-full items-center justify-center text-gray-400 gap-3 sm:gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-10 sm:size-12 md:size-16">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        <p class="text-xs sm:text-sm">Belum ada sampah yang dipilih</p>
                    </div>
                @endforelse
            </div>





        </div>
        <button type="button" wire:click="store"
            class="self-end py-1.5 sm:py-2 px-3 sm:px-4 bg-emerald-600 text-white text-xs sm:text-sm font-medium hover:bg-emerald-700 transition-colors duration-300 hover:cursor-pointer rounded-lg sm:rounded-xl">Buat
            Setoran</button>

    </div>

    <div x-cloak x-show="openModal" class="fixed inset-0 bg-black/50 z-50" x-transition.opacity></div>

    {{-- Sampah selection modal --}}
    <div x-cloak x-show="openModal"
        class="fixed flex flex-col w-[92%] sm:w-[90%] md:w-[85%] lg:w-[80%] h-[80vh] sm:h-[85vh] max-h-[90vh] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-3 sm:p-4 md:p-6 z-50 overflow-hidden"
        @click.away="openModal = false" x-transition>

        <!-- Header + Search Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-2 sm:mb-4 gap-2">
            <h2 class="text-base sm:text-lg font-semibold">Pilih Sampah</h2>
            <input type="text" placeholder="Cari sampah..."
                class="w-full sm:w-auto border border-gray-300 rounded-md px-2 sm:px-3 py-1 sm:py-1.5 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400"
                wire:model.live.debounce.300ms="searchsampah">
        </div>

        <!-- Grid Sampah -->
        <div class="flex-1 border border-gray-200 rounded-md bg-gray-100 p-1.5 sm:p-2 overflow-y-auto">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 sm:gap-3">
                @forelse ($allSampah as $sampah)
                    <div wire:click="{{ isset($selectedSampah[$sampah->id])
                        ? 'removeSampah(' . $sampah->id . ')'
                        : 'selectSampah(\'' .
                            $sampah->id .
                            '\', \'' .
                            $sampah->nama .
                            '\', \'' .
                            $sampah->image_url .
                            '\', \'' .
                            $sampah->harga_per_kg .
                            '\')' }}"
                        class="relative border rounded-lg overflow-hidden shadow-sm hover:shadow-md hover:cursor-pointer transition-all duration-300 
                            {{ isset($selectedSampah[$sampah->id])
                                ? 'ring-2 ring-emerald-500 border-emerald-500 transform scale-[1.02]'
                                : 'border-gray-200 hover:border-emerald-300' }}">

                        @if (isset($selectedSampah[$sampah->id]))
                            <div
                                class="absolute top-1 sm:top-2 right-1 sm:right-2 bg-emerald-500 text-white rounded-full p-0.5 sm:p-1 shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        @endif

                        <div class="p-2 sm:p-3 flex flex-col h-full">
                            <div class="flex justify-center mb-2 sm:mb-3">
                                <img src="{{ asset($sampah->image_url) }}" alt="{{ $sampah->nama }}"
                                    class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 object-cover rounded-md shadow-sm">
                            </div>
                            <div class="text-xs sm:text-sm font-medium text-center text-gray-800 mb-1 line-clamp-2">
                                {{ $sampah->nama }}</div>
                            <div class="mt-auto">
                                <div
                                    class="text-[10px] sm:text-xs text-center font-semibold text-emerald-700 bg-emerald-50 py-0.5 sm:py-1 px-1 sm:px-2 rounded-md">
                                    Rp{{ number_format($sampah->harga_per_kg, 0, ',', '.') }}/kg
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-6 sm:py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-gray-400 mb-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs sm:text-sm text-gray-400">Tidak ada data sampah ditemukan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-3 sm:mt-4 flex justify-end">
            <button type="button" @click="openModal = false"
                class="px-3 sm:px-4 py-1.5 sm:py-2 text-white rounded-md text-xs sm:text-sm font-medium bg-emerald-600 hover:bg-emerald-700 transition-colors duration-300 hover:cursor-pointer">Simpan</button>
        </div>

    </div>


</div>
