<x-layouts.app title="Postingan - Bank Sampah">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Postingan</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <!-- Filter & Search Form -->
            <form method="GET" action="{{ route('post.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Category Filter -->
                <div x-data="{ openCategoryFilter: false }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <div @click="openCategoryFilter = !openCategoryFilter"
                        class="flex justify-between items-center w-full px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                        :class="{ 'ring-2 ring-emerald-400': openCategoryFilter }">
                        <span class="truncate mr-2">
                            @if($currentCategory)
                                {{ $categories->firstWhere('slug', $currentCategory)->nama ?? 'Semua Kategori' }}
                            @else
                                Semua Kategori
                            @endif
                        </span>
                        <svg class="w-4 h-4 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <input type="hidden" name="category" id="category" value="{{ $currentCategory }}">
                    
                    <!-- Dropdown Options -->
                    <div x-show="openCategoryFilter" @click.away="openCategoryFilter = false" x-transition
                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                        <div @click="openCategoryFilter = false; document.getElementById('category').value = ''; document.getElementById('filterForm').submit()"
                            class="px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                            Semua Kategori
                        </div>
                        @foreach($categories as $category)
                            <div @click="openCategoryFilter = false; document.getElementById('category').value = '{{ $category->slug }}'; document.getElementById('filterForm').submit()"
                                class="px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition {{ $currentCategory == $category->slug ? 'bg-emerald-100 text-emerald-600' : '' }}">
                                {{ $category->nama }}
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Sort Dropdown -->
                <div x-data="{
                    openSortingFilter: false,
                    selected: '{{ $currentSort }}-{{ $currentDirection }}',
                    options: {
                        'created_at-desc': 'Tanggal dibuat terbaru',
                        'created_at-asc': 'Tanggal dibuat terlama',
                        'updated_at-desc': 'Tanggal diedit terbaru',
                        'updated_at-asc': 'Tanggal diedit terlama',
                        'judul-asc': 'Judul postingan [A-Z]',
                        'judul-desc': 'Judul postingan [Z-A]'
                    }
                }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan berdasarkan</label>

                    <div @click="openSortingFilter = !openSortingFilter"
                        class="flex justify-between items-center w-full px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300"
                        :class="{ 'ring-2 ring-emerald-400': openSortingFilter }">
                        <span class="truncate mr-2" x-text="options[selected] || 'Urutkan berdasarkan'"></span>
                        <svg class="w-4 h-4 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    
                    <input type="hidden" name="sort" id="sort">
                    <input type="hidden" name="direction" id="direction">

                    <!-- Dropdown Options -->
                    <div x-show="openSortingFilter" @click.away="openSortingFilter = false" x-transition
                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                        <template x-for="(label, value) in options" :key="value">
                            <div @click="openSortingFilter = false; selected = value; 
                                    document.getElementById('sort').value = value.split('-')[0]; 
                                    document.getElementById('direction').value = value.split('-')[1];
                                    document.getElementById('filterForm').submit()"
                                :class="{ 'bg-emerald-100 text-emerald-600': selected === value }"
                                class="px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                <span x-text="label"></span>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Search -->
                <div class="flex flex-col">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <div class="flex">
                        <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Cari postingan..."
                            class="flex-1 px-2 rounded-l-md border-1 border-gray-300 shadow-sm focus:ring-2 focus:outline-none focus:ring-emerald-400 transition duration-300">
                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-r-md hover:bg-emerald-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <input type="hidden" id="filterForm">
            </form>
        </div>
        
        @if($posts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl group">
                        <a href="{{ route('post.show', $post->slug) }}" class="block">
                            @if($post->images->isNotEmpty())
                                <div class="h-52 overflow-hidden">
                                    <img 
                                        src="{{ asset('storage/' . $post->images->first()->image_url) }}" 
                                        alt="{{ $post->judul }}" 
                                        class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                                    >
                                </div>
                            @else
                                <div class="h-52 bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </a>
                        
                        <div class="p-5">
                            <a href="{{ route('post.index', ['category' => $post->category->slug]) }}" class="inline-block">
                                <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-1 rounded-full mb-3 transition hover:bg-emerald-200">
                                    {{ $post->category->nama }}
                                </span>
                            </a>
                            
                            <h2 class="text-xl font-bold mb-3 line-clamp-2">
                                <a href="{{ route('post.show', $post->slug) }}" class="text-gray-900 hover:text-emerald-600 transition">
                                    {{ $post->judul }}
                                </a>
                            </h2>
                            
                            <div class="text-gray-700 mb-4 line-clamp-3 text-sm">
                                {!! Str::limit(strip_tags($post->konten), 150) !!}
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 pt-3 border-t border-gray-100">
                                <div class="flex items-center">
                                    <span>Oleh: {{ $post->author->nama_depan }} {{ $post->author->nama_belakang }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $post->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md p-6 text-center">
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg font-medium">Tidak ada postingan yang ditemukan</p>
                    <p class="text-sm mt-1">Coba ubah filter pencarian Anda atau cari dengan kata kunci lain</p>
                    <a href="{{ route('post.index') }}" class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">
                        Tampilkan semua postingan
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
