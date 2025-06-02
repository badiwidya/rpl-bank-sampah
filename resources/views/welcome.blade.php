<x-layouts.app title="Bank Sampah">

    <section class="min-h-screen flex flex-col md:flex-row p-4 md:p-16 bg-gray-50">
        <div class="w-full md:w-[60%] flex flex-col mb-8 md:mb-0">
            <h1 class="text-4xl md:text-6xl text-emerald-700 font-semibold text-wrap mb-4">Selamat Datang di Bank Sampah
                </h1>
            <div class="leading-7 md:leading-8 text-base md:text-lg">Bank Sampah hadir sebagai solusi cerdas untuk
                mengelola sampah dengan
                lebih efisien dan bertanggung jawab. Kami menyediakan wadah bagi Anda untuk menukarkan sampah yang
                terpilah dengan nilai ekonomi yang bermanfaat, sekaligus berkontribusi pada pelestarian lingkungan.
                Mari jadi bagian dari perubahan positif dengan mengelola sampah secara bijak.</div>
            <div class="flex mt-6 md:mt-8 gap-3 md:gap-4">
                <a href="{{ route('auth.login.choice') }}"
                    class="px-4 py-2 md:px-5 md:py-3 bg-emerald-600 text-white text-sm md:text-base font-medium rounded-full shadow-md border-1 border-emerald-700 hover:bg-emerald-700 hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 flex items-center">Bergabung
                    Sekarang</a>
                <a href="#second"
                    class="px-4 py-2 md:px-5 md:py-3 bg-white text-emerald-600 text-sm md:text-base font-medium rounded-full shadow-md border-1 border-emerald-600 hover:bg-gray-100 hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 flex items-center">Eksplor
                </a>
            </div>
        </div>
        <div class="flex items-center justify-center overflow-y-hidden">
            <img src="{{ asset('assets/recycling-icon-design 1.png') }}" alt="Recycling Image"
                class="w-64 md:w-128 h-auto object-cover">
        </div>
    </section>

    <section id="second"
        class="min-h-screen py-12 bg-emerald-100 flex flex-col justify-center items-center overflow-hidden px-4">
        <h1 class="text-3xl md:text-4xl font-semibold mb-6 md:mb-8 text-center">Sudahkah Anda menukar sampah hari ini?
        </h1>
        <div class="text-center w-full md:w-[50%] mb-4">
            "Selamat datang di platform penukaran Bank Sampah! Tukar sampah Anda dengan nilai lebih untuk membantu
            menjaga kebersihan lingkungan. Setiap kontribusi Anda berperan penting dalam menciptakan bumi yang lebih
            bersih dan sehat. Bergabunglah bersama kami, wujudkan lingkungan yang lebih baik untuk masa depan!"
        </div>
        <div class="overflow-hidden">
            <img src="{{ asset('assets/extrude-group.png') }}" alt="Orang bertukar"
                class="w-48 md:w-64 h-auto object-cover">
        </div>
    </section>

    <section id="berita"
        style="background-image: url('{{ asset('assets/bg-post-land-page.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
        class="min-h-screen flex flex-col justify-center items-center overflow-hidden py-8">
        <h1 class="text-white text-xl md:text-2xl font-semibold mt-8 md:mt-16">Berita Sampah Terkini</h1>
        <div class="flex-1 flex flex-col md:flex-row gap-6 md:gap-8 p-4 md:p-8 overflow-x-auto">
            @forelse ($posts as $post)
                <div
                    class="flex flex-col p-4 w-full md:w-64 bg-gray-100 rounded-lg transition-all duration-300 hover:-translate-y-1 md:hover:-translate-y-3.5
           flex-1 min-h-[400px]">
                    <a href="{{ route('post.show', ['post' => $post->slug]) }}"
                        class="h-36 overflow-hidden rounded-md mb-2 flex-shrink-0 flex justify-center items-center bg-gray-200">
                        @if ($post->images->first())
                            <img src="{{ Storage::url($post->images->first()->image_url) }}"
                                alt="{{ $post->judul }}" class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @endif
                    </a>
                    <a href="{{ route('post.show', ['post' => $post->slug]) }}"
                        class="font-semibold text-center hover:underline mb-2 truncate" title="{{ $post->judul }}">
                        {{ $post->judul }}
                    </a>
                    <p class="text-gray-600 text-sm text-center line-clamp-5">
                        {!! Str::limit(strip_tags($post->konten), 150) !!}
                    </p>
                </div>

            @empty
                <div class="w-full flex flex-col items-center justify-center py-20 text-gray-400">
                    <p class="text-lg font-semibold">Belum ada berita sampah terbaru</p>
                    <p class="text-center max-w-sm mt-2">Mohon cek kembali nanti, atau kunjungi halaman lainnya.</p>
                </div>
            @endforelse
        </div>
        <a href="{{ route('post.index') }}"
            class="flex uppercase p-3 mb-6 md:mb-8 rounded-xl bg-gray-100 hover:bg-gray-200 hover:cursor-pointer transition duration-300">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </a>
    </section>

    <section class="min-h-screen bg-[#013021] flex flex-col justify-center items-center overflow-hidden py-8">
        <div class="aspect-square h-12 md:h-16 w-12 md:w-16 overflow-hidden mb-4 mt-8 md:mt-16">
            <img src="{{ asset('assets/hand-around-leaf.png') }}" alt="Hand around leaf"
                class="h-full w-full object-cover">
        </div>
        <div class="text-white w-[90%] md:w-[70%] text-center text-base md:text-lg mb-4 px-4">
            Daur ulang di bank sampah kami tak hanya bersihkan lingkungan, tapi juga hasilkan uang tambahan. Setiap
            kilogram sampah yang Anda setor, selamatkan bumi.
            Ayo bergabung, jadi pahlawan lingkungan ♻️
        </div>
        <div class="flex-1 flex flex-col items-center p-4 md:p-8 mb-8 md:mb-16 bg-white rounded-xl w-[95%] md:w-[90%]">
            <h2 class="font-semibold text-xl md:text-2xl mb-4">Bagaimana Cara Kerjanya</h2>
            <div class="flex flex-col md:flex-row justify-around items-center w-full gap-6 md:gap-0">
                <div class="flex flex-col items-center">
                    <div
                        class="flex justify-center items-center aspect-square rounded-full w-24 md:w-32 h-24 md:h-32 overflow-hidden hover:-translate-y-2 bg-emerald-100 transition-all duration-400">
                        <img src="{{ asset('assets/register.svg') }}" alt="Phone" class="w-12 md:w-16 h-12 md:h-16">
                    </div>
                    <p class="font-semibold mt-4">Daftar</p>
                    <p class="text-gray-600 text-center">"Bergabung untuk berpartisipasi."</p>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="flex justify-center items-center aspect-square rounded-full w-24 md:w-32 h-24 md:h-32 overflow-hidden hover:-translate-y-2 bg-emerald-100 transition-all duration-400">
                        <img src="{{ asset('assets/collect.svg') }}" alt="Phone" class="w-12 md:w-16 h-12 md:h-16">
                    </div>
                    <p class="font-semibold mt-4">Kumpulkan</p>
                    <p class="text-gray-600 text-center">"Kumpulkan dan pisahkan sampah."</p>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="flex justify-center items-center aspect-square rounded-full w-24 md:w-32 h-24 md:h-32 overflow-hidden hover:-translate-y-2 bg-emerald-100 transition-all duration-400">
                        <img src="{{ asset('assets/impact.svg') }}" alt="Phone" class="w-12 md:w-16 h-12 md:h-16">
                    </div>
                    <p class="font-semibold mt-4">Berdampak</p>
                    <p class="text-gray-600 text-center">"Selamatkan lingkungan bumi."</p>
                </div>
            </div>
        </div>
    </section>

    <section id="hubungi-kami" class="min-h-screen flex flex-col justify-center items-center overflow-hidden h-screen">
        <div
            class="flex-grow-[7] bg-[#059669] w-full flex flex-col justify-center items-center overflow-hidden gap-6 md:gap-12 px-4 py-12 md:py-0">
            <h1 class="text-3xl md:text-5xl text-white font-semibold text-center">Siap gunakan layanan kami?</h1>
            <p class="text-center text-white w-full md:w-7/12 text-lg md:text-2xl font-light">
                "Tukarkan sampah Anda di Bank Sampah, bantu lingkungan tetap bersih dan dapatkan manfaat berkelanjutan!"
            </p>
            <a href="{{ route('auth.login.choice') }}"
                class="py-2 md:py-3 px-6 md:px-8 bg-white rounded-full text-[#059669] hover:bg-gray-300 hover:cursor-pointer transition duration-300">
                Coba Sekarang
            </a>
        </div>

        <div class="flex-grow-[3] bg-[#1F2937] w-full flex flex-col py-4">
            <div class="flex-1 flex text-2xl md:text-3xl font-semibold text-white gap-4 justify-center items-center">
                <!-- icon + title -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="size-6 md:size-8">
                    <path fill-rule="evenodd"
                        d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z"
                        clip-rule="evenodd" />
                </svg>
                Hubungi Kami
            </div>
            <div class="flex flex-col md:flex-row justify-between p-2 gap-4 md:gap-0">
                <div class="flex gap-2 text-white text-base md:text-xl items-center justify-center md:justify-start">
                    <!-- icon + text -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 md:size-8" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M 8 3 C 5.239 3 3 5.239 3 8 L 3 16 C 3 18.761 5.239 21 8 21 L 16 21 C 18.761 21 21 18.761 21 16 L 21 8 C 21 5.239 18.761 3 16 3 L 8 3 z M 18 5 C 18.552 5 19 5.448 19 6 C 19 6.552 18.552 7 18 7 C 17.448 7 17 6.552 17 6 C 17 5.448 17.448 5 18 5 z M 12 7 C 14.761 7 17 9.239 17 12 C 17 14.761 14.761 17 12 17 C 9.239 17 7 14.761 7 12 C 7 9.239 9.239 7 12 7 z M 12 9 A 3 3 0 0 0 9 12 A 3 3 0 0 0 12 15 A 3 3 0 0 0 15 12 A 3 3 0 0 0 12 9 z">
                        </path>
                    </svg>
                    @banksampah
                </div>
                <div
                    class="flex gap-2 md:gap-4 text-white text-base md:text-xl items-center justify-center md:justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 md:size-8" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M19.077,4.928C17.191,3.041,14.683,2.001,12.011,2c-5.506,0-9.987,4.479-9.989,9.985 c-0.001,1.76,0.459,3.478,1.333,4.992L2,22l5.233-1.237c1.459,0.796,3.101,1.215,4.773,1.216h0.004 c5.505,0,9.986-4.48,9.989-9.985C22.001,9.325,20.963,6.816,19.077,4.928z M16.898,15.554c-0.208,0.583-1.227,1.145-1.685,1.186 c-0.458,0.042-0.887,0.207-2.995-0.624c-2.537-1-4.139-3.601-4.263-3.767c-0.125-0.167-1.019-1.353-1.019-2.581 S7.581,7.936,7.81,7.687c0.229-0.25,0.499-0.312,0.666-0.312c0.166,0,0.333,0,0.478,0.006c0.178,0.007,0.375,0.016,0.562,0.431 c0.222,0.494,0.707,1.728,0.769,1.853s0.104,0.271,0.021,0.437s-0.125,0.27-0.249,0.416c-0.125,0.146-0.262,0.325-0.374,0.437 c-0.125,0.124-0.255,0.26-0.11,0.509c0.146,0.25,0.646,1.067,1.388,1.728c0.954,0.85,1.757,1.113,2.007,1.239 c0.25,0.125,0.395,0.104,0.541-0.063c0.146-0.166,0.624-0.728,0.79-0.978s0.333-0.208,0.562-0.125s1.456,0.687,1.705,0.812 c0.25,0.125,0.416,0.187,0.478,0.291C17.106,14.471,17.106,14.971,16.898,15.554z">
                        </path>
                    </svg>
                    089677890706
                </div>
                <div
                    class="flex gap-2 md:gap-4 text-white text-base md:text-xl items-center justify-center md:justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 md:size-8" viewBox="0 0 50 50"
                        fill="currentColor">
                        <path
                            d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10 c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56 c3.97,0,7.19,2.73,7.19,8.26V39z">
                        </path>
                    </svg>
                    Bank Sampah
                </div>
            </div>
        </div>
    </section>


</x-layouts.app>
