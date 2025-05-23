<div class="bg-gradient-to-b from-emerald-50 py-4 sm:py-6 md:py-8 to-emerald-200 min-h-full min-w-full">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0 mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Kelola Postingan</h1>
            <a wire:navigate href="{{ route('admin.dashboard.post.create') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-1.5 sm:py-2 px-3 sm:px-4 text-sm sm:text-base rounded-lg flex items-center shadow-md transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1.5 sm:mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Postingan Baru
            </a>
        </div>

        <!-- Filter dan pencarian -->
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 md:p-6 mb-4 sm:mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div class="space-y-3 sm:space-y-4">
                    <!-- Pencarian -->
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="term"
                            class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                            placeholder="Cari judul atau konten postingan...">
                        <div class="absolute left-2.5 sm:left-3 top-2 sm:top-2.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Filter Kategori -->
                    <div x-data="{
                        openCategoryFilter: false,
                        selectedId: @entangle('categoryFilter'),
                        getSelectedName() {
                            if (!this.selectedId) return 'Semua Kategori';
                            const category = this.$el.querySelector(`[data-id='${this.selectedId}']`);
                            return category ? category.innerText : 'Semua Kategori';
                        }
                    }" class="relative">
                        <div @click="openCategoryFilter = !openCategoryFilter"
                            class="flex justify-between items-center w-full px-3 sm:px-4 py-1.5 sm:py-2 bg-white border border-gray-300 rounded-md text-xs sm:text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                            :class="{ 'ring-2 ring-emerald-400': openCategoryFilter }">
                            <span class="truncate mr-2" x-text="getSelectedName()"></span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <div x-show="openCategoryFilter" @click.away="openCategoryFilter = false" x-transition
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-48 sm:max-h-60 overflow-y-auto"
                            x-cloak>
                            <div @click="openCategoryFilter = false; $wire.set('categoryFilter', '')"
                                class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                Semua Kategori
                            </div>
                            @foreach ($categories as $category)
                                <div @click="openCategoryFilter = false; $wire.set('categoryFilter', '{{ $category->id }}')"
                                    data-id="{{ $category->id }}"
                                    class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                    {{ $category->nama }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    <!-- Filter Tanggal -->
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
                    }" class="relative">
                        <!-- Label -->
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Filter berdasarkan waktu</label>

                        <!-- Dropdown Trigger -->
                        <div @click="openTimeFilter = !openTimeFilter"
                            class="flex justify-between items-center w-full px-3 sm:px-4 py-1.5 sm:py-2 bg-white border border-gray-300 rounded-md text-xs sm:text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                            :class="{ 'ring-2 ring-emerald-400': openTimeFilter }">
                            <span class="truncate mr-2" x-text="options[selected] || 'Filter berdasar waktu'"></span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Dropdown Options -->
                        <div x-show="openTimeFilter" @click.away="openTimeFilter = false" x-transition
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg"
                            x-cloak>
                            <template x-for="(label, value) in options" :key="value">
                                <div @click="openTimeFilter = false; $wire.set('dateFilter', value)"
                                    class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                    <span x-text="label"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-data="{
                        openSortingFilter: false,
                        selected: @entangle('sortOption'),
                        options: {
                            'created_at-desc': 'Tanggal dibuat terbaru',
                            'created_at-asc': 'Tanggal dibuat terlama',
                            'updated_at-desc': 'Tanggal diedit terbaru',
                            'updated_at-asc': 'Tanggal diedit terlama',
                            'judul-asc': 'Judul postingan [A-Z]',
                            'judul-desc': 'Judul postingan [Z-A]'
                        }
                    }" class="relative">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Urutkan berdasarkan</label>

                        <div @click="openSortingFilter = !openSortingFilter"
                            class="flex justify-between items-center w-full px-3 sm:px-4 py-1.5 sm:py-2 bg-white border border-gray-300 rounded-md text-xs sm:text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                            :class="{ 'ring-2 ring-emerald-400': openSortingFilter }">
                            <span class="truncate mr-2" x-text="options[selected] || 'Urutkan berdasarkan'"></span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Dropdown Options -->
                        <div x-show="openSortingFilter" @click.away="openSortingFilter = false" x-transition
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                            <template x-for="(label, value) in options" :key="value">
                                <div @click="openSortingFilter = false; $wire.set('sortOption', value)"
                                    class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                    <span x-text="label"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-white rounded-lg shadow-md overflow-hidden overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">
                            Konten Postingan
                        </th>
                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6 hidden sm:table-cell">
                            Kategori
                        </th>
                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6 hidden sm:table-cell">
                            Tanggal
                        </th>
                        <th scope="col"
                            class="px-3 sm:px-6 py-2 sm:py-3 text-right sm:text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                        <tr wire:key="{{ $post->id }}" class="hover:bg-gray-50">
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex flex-col">
                                    <div class="flex items-center mb-1 sm:mb-2">
                                        @if ($post->images->count() > 0)
                                            <div class="h-8 w-8 sm:h-12 sm:w-12 flex-shrink-0 mr-2 sm:mr-3">
                                                <img class="h-8 w-8 sm:h-12 sm:w-12 rounded-md object-cover"
                                                    src="{{ Storage::disk('public')->url($post->images->first()->image_url) }}"
                                                    alt="{{ $post->judul }}">
                                            </div>
                                        @endif
                                        <div class="text-xs sm:text-sm font-medium text-gray-900 max-sm:line-clamp-2">{{ $post->judul }}</div>
                                    </div>
                                    <div class="trix-content text-xs text-gray-600 mt-1 sm:mt-2 pr-2 sm:pr-4 max-sm:line-clamp-2 sm:line-clamp-3">
                                        {!! Str::limit(strip_tags($post->konten), 100) !!}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1 hidden sm:block">
                                        Dibuat oleh: {{ $post->author->nama_depan }} {{ $post->author->nama_belakang }}
                                    </div>
                                    <!-- Mobile only info -->
                                    <div class="flex flex-wrap gap-1 mt-1 sm:hidden">
                                        <span class="text-xs text-gray-500">{{ $post->created_at->format('d M Y') }}</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                            {{ $post->category->nama ?? 'Tidak ada kategori' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    {{ $post->category->nama ?? 'Tidak ada kategori' }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden sm:table-cell">
                                {{ $post->created_at->format('d M Y') }}
                                <div class="text-xs text-gray-400">
                                    {{ $post->created_at->format('H:i') }}
                                </div>
                                @if ($post->updated_at->gt($post->created_at))
                                    <div class="text-xs text-emerald-500 mt-1 font-medium">
                                        Diperbarui: {{ $post->updated_at->format('d M Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right sm:text-left text-xs sm:text-sm font-medium">
                                <div class="flex space-x-1 sm:space-x-2 justify-end sm:justify-start">
                                    <button wire:click="edit({{ $post->id }})"
                                        class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-1.5 sm:p-2 rounded-full transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $post->id }})"
                                        class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-1.5 sm:p-2 rounded-full transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 sm:px-6 py-6 sm:py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-12 sm:w-12 text-gray-400 mb-2 sm:mb-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <p class="text-base sm:text-lg font-semibold mb-1">Belum ada postingan</p>
                                    <p class="text-xs sm:text-sm">Tidak ada postingan yang ditemukan berdasarkan filter yang
                                        dipilih</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-3 sm:px-6 py-2 sm:py-3 bg-gray-50 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
        </div>

        <div x-cloak x-show="$wire.deleteConfirmation" class="fixed inset-0 bg-black/50 z-50" x-transition.opacity>
        </div>

        <div x-cloak x-show="$wire.deleteConfirmation"
            class="flex flex-col fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-lg p-4 sm:p-6 z-50 w-[85%] sm:w-auto max-w-lg"
            @click.away="$wire.deleteConfirmation = false">
            <h3 class="text-base sm:text-lg font-semibold mb-2 sm:mb-4">Konfirmasi Hapus</h3>
            <p class="mb-4 sm:mb-6 text-sm sm:text-base text-gray-700">Apakah Anda yakin ingin menghapus postingan ini? Tindakan ini tidak dapat
                dibatalkan.</p>

            <div class="flex justify-end space-x-2 sm:space-x-3">
                <button type="button"
                    class="px-3 sm:px-4 py-1.5 sm:py-2 hover:cursor-pointer rounded text-xs sm:text-sm bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold"
                    @click="$wire.deleteConfirmation = false">
                    Batal
                </button>

                <button type="button"
                    class="px-3 sm:px-4 py-1.5 sm:py-2 hover:cursor-pointer rounded text-xs sm:text-sm bg-red-600 hover:bg-red-700 text-white font-semibold"
                    wire:click="delete">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
