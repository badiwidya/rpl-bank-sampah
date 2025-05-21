<x-layouts.app title="{{ $post->judul }} - Bank Sampah">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('post.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Postingan
            </a>
        </div>
        
        <article class="bg-white rounded-lg shadow-lg overflow-hidden mb-10">
            <!-- Post Header -->
            <header class="p-6 lg:p-8 border-b border-gray-200">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <a href="{{ route('post.index', ['category' => $post->category->slug]) }}" 
                       class="inline-block bg-emerald-100 text-emerald-800 text-sm font-medium px-3 py-1 rounded-full hover:bg-emerald-200 transition">
                        {{ $post->category->nama }}
                    </a>
                    <span class="text-gray-500 text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $post->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->judul }}</h1>
                <div class="flex items-center text-sm text-gray-600">
                    <span>Ditulis oleh <span class="font-semibold">{{ $post->author->nama_depan }} {{ $post->author->nama_belakang }}</span></span>
                </div>
            </header>
            
            <!-- Post Images Gallery -->
            @if($post->images->isNotEmpty())
                <div class="relative">
                    <div id="mainImage" class="overflow-hidden max-h-[500px]">
                        <img 
                            id="featuredImage"
                            src="{{ asset('storage/' . $post->images->first()->image_url) }}" 
                            alt="{{ $post->judul }}" 
                            class="w-full object-cover"
                        >
                    </div>
                    
                    @if($post->images->count() > 1)
                        <div class="p-4 flex flex-wrap gap-2 justify-center">
                            @foreach($post->images as $index => $image)
                                <img 
                                    src="{{ asset('storage/' . $image->image_url) }}" 
                                    alt="{{ $post->judul }} - Image {{ $index + 1 }}" 
                                    class="h-20 w-20 object-cover rounded-md cursor-pointer hover:opacity-90 border-2 {{ $loop->first ? 'border-emerald-500' : 'border-transparent' }} transition-all"
                                    onclick="changeMainImage('{{ asset('storage/' . $image->image_url) }}', this)"
                                >
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
            
            <!-- Post Content -->
            <div class="p-6 lg:p-8 trix-editor prose max-w-none flex flex-col items-center trix-content trix-nocaption">
                {!! $post->konten !!}
            </div>
            
            <!-- Post Footer -->
            <div class="p-6 lg:p-8 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span>Terakhir diperbarui: {{ $post->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="#" class="p-2 bg-gray-200 text-gray-600 rounded-full hover:bg-gray-300 transition-all" title="Bagikan ke Facebook">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="#" class="p-2 bg-gray-200 text-gray-600 rounded-full hover:bg-gray-300 transition-all" title="Bagikan ke Twitter">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                            </svg>
                        </a>
                        <a href="#" class="p-2 bg-gray-200 text-gray-600 rounded-full hover:bg-gray-300 transition-all" title="Bagikan ke WhatsApp">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </article>
        
        <!-- Related Posts -->
        @if($relatedPosts->isNotEmpty())
            <div class="mt-12 mb-10">
                <h2 class="text-2xl font-bold mb-6">Postingan Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 group">
                            <a href="{{ route('post.show', $relatedPost->slug) }}" class="block">
                                @if($relatedPost->images->isNotEmpty())
                                    <div class="h-44 overflow-hidden">
                                        <img 
                                            src="{{ asset('storage/' . $relatedPost->images->first()->image_url) }}" 
                                            alt="{{ $relatedPost->judul }}" 
                                            class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                                        >
                                    </div>
                                @else
                                    <div class="h-44 bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 line-clamp-2">
                                    <a href="{{ route('post.show', $relatedPost->slug) }}" class="text-gray-900 hover:text-emerald-600 transition">
                                        {{ $relatedPost->judul }}
                                    </a>
                                </h3>
                                
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span class="inline-block bg-emerald-100 text-emerald-800 text-xs px-2.5 py-0.5 rounded-full">
                                        {{ $relatedPost->category->nama }}
                                    </span>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $relatedPost->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        function changeMainImage(imageSrc, thumbnailElement) {
            // Update main image
            document.getElementById('featuredImage').src = imageSrc;
            
            // Update thumbnail borders (remove from all, add to clicked)
            const allThumbnails = document.querySelectorAll('#mainImage + div img');
            allThumbnails.forEach(thumb => {
                thumb.classList.remove('border-emerald-500');
                thumb.classList.add('border-transparent');
            });
            
            thumbnailElement.classList.remove('border-transparent');
            thumbnailElement.classList.add('border-emerald-500');
        }
    </script>
</x-layouts.app>
