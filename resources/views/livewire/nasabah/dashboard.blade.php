<div x-data="{ tarikSaldo: @entangle('tarikSaldo') }" class="flex flex-col min-h-full min-w-full"
    style="background: linear-gradient(179deg, #F4F4F4 15.93%, #C7E4DB 57.49%, #99D4C2 99.05%); background-repeat: no-repeat;">

    <div class="w-full flex flex-col flex-1 justify-center items-center">
        <div x-data="greetingHandler()" x-init="updateGreeting();
        setInterval(updateGreeting, 60000)">
            <h3 class="font-regular text-gray-600 text-2xl">Selamat <span x-text="greeting"></span>,
                <span class="font-semibold text-emerald-600">{{ $user->nama_depan . ' ' . $user->nama_belakang }}</span>!
            </h3>
        </div>
        <h1 class="font-semibold text-gray-800 text-4xl">Sudahkah Anda menyetorkan sampah hari ini?</h1>
        <div class="flex gap-4 mt-8">
            <a wire:navigate href="{{ route('nasabah.dashboard.sampah') }}"
                class="block px-3 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl transition duration-300">Daftar
                Harga
                Sampah</a>
            <a href="/news"
                class="block px-3 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl transition duration-300">Berita
                Sampah
                Terkini</a>
        </div>
    </div>

    <div class="flex mb-4 mx-4 gap-4">

        <div @click="tarikSaldo = true"
            class="group flex flex-col w-70 min-w-70 flex-grow-0 bg-white overflow-hidden backdrop-blur-md rounded-xl shadow-xl p-5 transition-all duration-500 hover:w-100 hover:shadow-2xl cursor-pointer">

            <h3 class="font-semibold text-base cursor-pointer">Tarik Saldo</h3>

            <div class="flex flex-col space-y-3">
                <div class="flex flex-col">
                    <label class="text-xs text-gray-600 font-medium mb-0.5 cursor-pointer">Nominal</label>
                    <div class="relative">
                        <span
                            class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm cursor-pointer">Rp</span>
                        <input type="text" placeholder="Masukkan nominal..."
                            class="w-full bg-gray-50 border border-gray-300 pl-7 pr-2 py-1 rounded-md text-sm focus:ring-1 focus:ring-blue-300 focus:border-blue-500 focus:outline-none transition-all cursor-pointer">
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-600 font-medium mb-0.5 cursor-pointer">Metode Penarikan</label>
                    <div class="relative">
                        <select disabled
                            class="w-full bg-gray-50 border border-gray-300 pl-2 pr-6 py-1 rounded-md text-sm appearance-none focus:ring-1 focus:ring-blue-300 focus:border-blue-500 focus:outline-none transition-all cursor-pointer">
                            <option value="" disabled selected>Pilih metode...</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-1 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 cursor-pointer" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-auto text-xs text-gray-500 pt-2 cursor-pointer">
                Klik untuk detail lengkap
            </div>
        </div>


        <div
            class="flex flex-1 max-w-full lg:max-w-120 items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8 hover:scale-103 transition duration-500">
            <div class="flex flex-col items-start gap-2 overflow-hidden max-w-[70%]">
                <div class="w-full">
                    <p class="text-sm font-regular text-gray-600 truncate">Saldo</p>
                    <p class="font-semibold text-md truncate">
                        {{ 'Rp ' . number_format($user->profile->saldo, 2, ',', '.') }}</p>
                </div>
                <div class="w-full">
                    <p class="text-sm font-regular text-gray-600 truncate">Total Pemasukan</p>
                    <p class="font-semibold text-md truncate">{{ 'Rp ' . number_format($totalPendapatan, 2, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('assets/money-bag.png') }}" alt="" class="w-full h-auto">
            </div>
        </div>


        <div
            class="flex flex-1 max-w-full lg:max-w-120 items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8 hover:scale-103 transition duration-500">
            <div class="flex flex-col items-start overflow-hidden max-w-[70%] w-full">
                <p class="text-sm font-regular text-gray-600 truncate w-full">Total Sampah</p>
                <p class="text-sm font-regular text-gray-600 truncate w-full">Terkumpul</p>
                <p class="font-semibold text-md truncate">{{ $totalBeratSampah . ' kg' }}</p>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('assets/flat-trash-can.png') }}" alt="" class="w-full h-auto">
            </div>
        </div>

        <a class="w-full flex-1 flex items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8 max-w-full lg:max-w-120 hover:scale-103 transition duration-500"
            href="{{ route('nasabah.dashboard.setoran') }}" wire:navigate>
            <div class="flex flex-col items-start gap-2 overflow-hidden max-w-[70%]">
                <div class="w-full">
                    <p class="text-sm font-regular text-gray-600 truncate">Setoran Hari Ini</p>
                    <p class="font-semibold text-md truncate">{{ $totalSetoranHariIni }}</p>
                </div>
                <div class="w-full">
                    <p class="text-sm font-regular text-gray-600 truncate">Setoran Bulan Ini</p>
                    <p class="font-semibold text-md truncate">{{ $totalSetoranBulanIni }}</p>
                </div>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('assets/trans.png') }}" alt="" class="w-full h-auto">
            </div>
        </a>
    </div>

    <div x-cloak x-show="tarikSaldo" class="fixed inset-0 bg-black/50 z-50"></div>


    <div x-cloak x-show="tarikSaldo" @click.away="tarikSaldo = false" x-on:tarik-success.window="tarikSaldo = false"
        class="w-4/5 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-lg p-6 z-50"
        x-transition>
        <livewire:nasabah.tarik-saldo />
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
