<div class="flex justify-center bg-gradient-to-b from-emerald-50 to-emerald-200 min-h-full min-w-full">
    <div class="py-6 sm:py-8 w-full sm:w-11/12 md:w-10/12 lg:w-4/5 mx-auto px-4 sm:px-6 @cannot('create', \App\Models\Sampah::class) max-w-3/5 @endcannot">


        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <div class="w-full sm:w-1/2">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="term"
                        class="bg-white w-full pl-10 pr-4 py-2 rounded-lg border drop-shadow-sm border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition duration-300"
                        placeholder="Cari sampah...">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            @can('create', \App\Models\Sampah::class)
                <div class="flex gap-2 sm:gap-4">
                    <a href="{{ route('admin.dashboard.sampah.log') }}" wire:navigate
                        class="bg-white hover:bg-emerald-600 drop-shadow-md hover:cursor-pointer text-emerald-600 hover:text-white border-1 border-emerald-600 font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center transition duration-150 ease-in-out text-sm sm:text-base">
                        Log
                    </a>
                    <button wire:click="createSampah"
                        class="bg-emerald-600 hover:bg-emerald-700 drop-shadow-md hover:cursor-pointer text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center transition duration-150 ease-in-out text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden xs:inline">Tambah Sampah</span>
                        <span class="xs:hidden">Tambah</span>
                    </button>
                </div>
            @endcan

        </div>

        <!-- Tabel -->
        <div class="bg-white rounded-lg shadow-md overflow-x-auto mx-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="w-14 sm:w-16 px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span class="hidden sm:inline">Gambar</span>
                            <span class="sm:hidden">Img</span>
                        </th>

                        <th scope="col"
                            class="min-w-50 max-w-50 truncate px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('nama')">
                            <div class="flex items-center">
                                Nama
                                <span class="ml-1">
                                    @if ($sortField === 'nama')
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
                            class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('harga_per_kg')">
                            <div class="flex items-center">
                                <span class="hidden sm:inline">Harga/kg</span>
                                <span class="sm:hidden">Harga</span>
                                <span class="ml-1">
                                    @if ($sortField === 'harga_per_kg')
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

                        @if (auth()->user()->can('update', \App\Models\Sampah::class) ||
                                auth()->user()->can('delete', \App\Models\Sampah::class))
                            <th scope="col"
                                class="hidden sm:table-cell w-28 sm:w-40 px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('created_at')">
                                <div class="flex items-center">
                                    <span class="hidden md:inline">Tgl. Dibuat</span>
                                    <span class="md:hidden">Tanggal</span>
                                    <span class="ml-1">
                                        @if ($sortField === 'created_at')
                                            @if ($sortDirection === 'asc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
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
                                class="w-20 sm:w-24 px-2 sm:px-6 py-2 sm:py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        @endif
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jenisSampah as $item)
                        <tr wire:key="{{ $item->id }}" class="hover:bg-gray-50">
                            <td class="px-2 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded overflow-hidden bg-gray-100">
                                    <img src="{{ asset($item->image_url) }}" alt="{{ $item->nama }}"
                                        class="h-full w-full object-cover">
                                </div>
                            </td>
                            <td class="px-2 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                            </td>
                            <td class="px-2 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm text-gray-900">
                                    Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</div>
                            </td>
                            @if (auth()->user()->can('update', \App\Models\Sampah::class) ||
                                    auth()->user()->can('delete', \App\Models\Sampah::class))
                                <td class="hidden sm:table-cell px-2 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                    <div class="text-xs sm:text-sm font-light text-gray-900">
                                        {{ $item->created_at->format('d/m/y') }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                    <div class="flex space-x-1 sm:space-x-2 justify-center">
                                        <button wire:click="editSampah({{ $item->id }})"
                                            class="text-white bg-indigo-600 hover:bg-indigo-900 p-1 rounded-md hover:cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $item->id }})"
                                            class="text-white bg-red-600 hover:bg-red-900 p-1 rounded-md hover:cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()?->role === 'admin' ? '5' : '3' }}"
                                class="px-2 sm:px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-gray-400 mb-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xs sm:text-sm">Tidak ada data sampah ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-2 sm:px-6 py-3 bg-gray-50 border-t border-gray-200 overflow-x-auto">
                {{ $jenisSampah->links() }}
            </div>
        </div>

        @if (auth()->user()->role === 'admin')
            <div x-cloak x-show="$wire.deleteConfirmation || $wire.editModal || $wire.createModal"
                class="fixed inset-0 bg-black/50 z-50" x.transition.opacity></div>

            {{-- delete confirmation modal --}}
            <div x-cloak wire:show="deleteConfirmation"
                class="flex flex-col fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-lg p-4 sm:p-6 z-50 w-11/12 max-w-md"
                @click.away="$wire.deleteConfirmation = false">
                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Konfirmasi Hapus</h3>
                <p class="mb-5 sm:mb-6 text-sm sm:text-base text-gray-700">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat
                    dibatalkan.</p>

                <div class="flex justify-end space-x-3">
                    <button type="button"
                        class="px-3 sm:px-4 py-1.5 sm:py-2 text-sm hover:cursor-pointer rounded bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold"
                        @click="$wire.deleteConfirmation = false">
                        Batal
                    </button>

                    <button type="button"
                        class="px-3 sm:px-4 py-1.5 sm:py-2 text-sm hover:cursor-pointer rounded bg-red-600 hover:bg-red-700 text-white font-semibold"
                        wire:click="delete">
                        Hapus
                    </button>
                </div>
            </div>

            {{--  Edit modal  --}}
            <div x-cloak wire:show="editModal"
                class="flex flex-col fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-lg p-4 sm:p-6 z-50 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2 max-h-[90vh] overflow-y-auto"
                @click.away="$wire.editModal = false">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base sm:text-lg font-semibold">{{ $mode === 'edit' ? 'Edit Sampah' : 'Tambah Sampah Baru' }}</h3>
                    <button @click="$wire.editModal = false" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="{{ $mode === 'edit' ? 'update' : 'store' }}">
                    <div class="mb-4 flex flex-col sm:flex-row items-center gap-2">
                        <div
                            class="flex items-center justify-center h-28 w-28 sm:h-36 sm:w-36 overflow-hidden rounded-md border-1 border-dashed bg-gray-300">
                            @if ($imageUpload)
                                <img class="h-full w-full object-cover" src="{{ $imageUpload->temporaryUrl() }}"
                                    alt="Image upload">
                            @elseif($imagePath)
                                <img class="h-full w-full object-cover" src="{{ asset($imagePath) }}"
                                    alt="Image default">
                            @else
                                <p class="font-semibold text-gray-400 text-sm sm:text-base">NO IMAGE</p>
                            @endif
                        </div>
                        <div class="flex flex-col w-full sm:w-auto">
                            <button type="button"
                                class="flex self-center sm:self-end px-3 sm:px-4 py-1.5 sm:py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm rounded-md"
                                @click="$refs.fileInput.click()">
                                Pilih Gambar
                            </button>
                            <input type="file" wire:model="imageUpload" accept=".jpeg,.jpg,.png" class="hidden"
                                x-ref="fileInput">
                            @error('imageUpload')
                                <div class="text-red-500 text-xs my-1 text-center sm:text-left sm:self-end">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama Sampah</label>
                        <input type="text" name="nama" wire:model.defer="dataInput.nama"
                            class="w-full border-gray-300 px-3 sm:px-4 py-1.5 sm:py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('dataInput.nama') border-red-500 focus:ring-red-500 @enderror" />
                        @error('dataInput.nama')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Harga per kg</label>
                        <div
                            class="flex items-center border-gray-300 border rounded-md px-3 focus-within:ring-2 focus-within:ring-emerald-400 transition duration-300 @error('dataInput.harga_per_kg') border-red-500 focus-within:ring-red-500 @enderror">
                            <span class="text-xs sm:text-sm text-gray-700 select-none">Rp.</span>
                            <input type="number" name="harga_per_kg" step="0.01" min="1"
                                wire:model.defer="dataInput.harga_per_kg"
                                class="flex-1 px-2 py-1.5 sm:py-2 text-xs sm:text-sm placeholder:text-sm border-none focus:outline-none" />
                            <span class="text-xs sm:text-sm text-gray-700 select-none">/kg</span>
                        </div>
                        @error('dataInput.harga_per_kg')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="flex justify-end space-x-3">
                        <button type="button"
                            class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm hover:cursor-pointer rounded bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold"
                            @click="$wire.editModal = false">
                            Batal
                        </button>

                        <button type="submit"
                            class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm hover:cursor-pointer rounded bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        @endif


    </div>
</div>
