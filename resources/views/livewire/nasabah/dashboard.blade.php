<div class="flex flex-col min-h-full min-w-full"
    style="background: linear-gradient(179deg, #F4F4F4 15.93%, #C7E4DB 57.49%, #99D4C2 99.05%); background-repeat: no-repeat;">

    <div class="w-full flex flex-col flex-1 justify-center items-center">
        <div x-data="greetingHandler()" x-init="updateGreeting();
        setInterval(updateGreeting, 60000)">
            <h3 class="font-regular text-gray-600 text-2xl">Selamat <span x-text="greeting"></span>,
                <span class="font-semibold text-emerald-600">{{ $user->nama_depan . ' ' . $user->nama_belakang }}</span>!
                </h1>
        </div>
        <h1 class="font-semibold text-gray-800 text-4xl">Sudahkah Anda menyetorkan sampah hari ini?</h2>
            <div class="flex gap-4 mt-8">
                <a wire:navigate href="{{ route('nasabah.dashboard.sampah') }}"
                    class="block px-3 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl transition duration-300">Daftar Harga
                    Sampah</a>
                <a href="/news"
                    class="block px-3 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl transition duration-300">Berita Sampah
                    Terkini</a>
            </div>
    </div>

    <div class="flex mb-8 mx-8 gap-12">
        <div class="flex flex-1 max-w-100 items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8">
            <div class="flex flex-col items-start gap-2">
                <div>
                    <p class="text-md font-regular text-gray-600">Saldo</p>
                    <p class="font-semibold text-lg">{{ 'Rp ' . number_format($user->profile->saldo, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-md font-regular text-gray-600">Total Pemasukan</p>
                    <p class="font-semibold text-lg">{{ 'Rp ' . number_format($totalPendapatan, 2, ',', '.') }}</p>
                </div>
            </div>
            <div>
                <img src="{{ asset('assets/money-bag.png') }}" alt="">
            </div>
        </div>


        <div class="flex flex-1 max-w-100 items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8">
            <div class="flex flex-col items-start gap-2">
                <p class="text-md font-regular text-gray-600">Total Sampah Terkumpul</p>
                <p class="font-semibold text-lg">{{ $totalBeratSampah . ' kg' }}</p>
            </div>
            <div>
                <img src="{{ asset('assets/flat-trash-can.png') }}" alt="">
            </div>
        </div>

        <div class="flex flex-1 max-w-100 items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8">
            <div class="flex flex-col items-start gap-2">
                <div>
                    <p class="text-md font-regular text-gray-600">Setoran Hari Ini</p>
                    <p class="font-semibold text-lg">{{ $totalSetoranHariIni }}</p>
                </div>
                <div>
                    <p class="text-md font-regular text-gray-600">Setoran Bulan Ini</p>
                    <p class="font-semibold text-lg">{{ $totalSetoranBulanIni }}</p>
                </div>
            </div>
            <div>
                <img src="{{ asset('assets/trans.png') }}" alt="">
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
