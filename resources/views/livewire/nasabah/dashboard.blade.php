<div x-data="{ tarikSaldo: @entangle('tarikSaldo') }" class="flex flex-col min-h-full min-w-full"
    style="background: linear-gradient(179deg, #F4F4F4 15.93%, #C7E4DB 57.49%, #99D4C2 99.05%); background-repeat: no-repeat;">

    <div class="w-full flex flex-col flex-1 justify-center items-center py-8 px-4">
        <div x-data="greetingHandler()" x-init="updateGreeting();
        setInterval(updateGreeting, 60000)" class="mb-2 text-center">
            <h3 class="font-light text-gray-700 text-2xl">
                Selamat <span x-text="greeting" class="italic"></span>,
                <span class="font-bold text-emerald-600 transition-all duration-300 hover:text-emerald-700">
                    {{ $user->nama_depan . ' ' . $user->nama_belakang }}
                </span>!
            </h3>
        </div>

        <h1 class="font-semibold text-gray-800 text-4xl text-center leading-tight max-w-3xl mb-6">
            Sudahkah Anda menyetorkan sampah hari ini?
        </h1>

        <div class="flex gap-6 mt-6">
            <a wire:navigate href="{{ route('nasabah.dashboard.sampah') }}"
                class="px-5 py-3 bg-emerald-600 text-white font-medium rounded-xl shadow-md hover:bg-emerald-700 hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Daftar Harga Sampah
            </a>
            <a href="/news"
                class="px-5 py-3 bg-white text-emerald-600 font-medium border-2 border-emerald-600 rounded-xl hover:bg-emerald-50 transform hover:-translate-y-0.5 transition duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Berita Sampah Terkini
            </a>
        </div>
    </div>

    <div class="flex mb-4 mx-4 gap-4">

        <div @click="tarikSaldo = true"
            class="flex justify-center items-center gap-2 flex-1 bg-white overflow-hidden backdrop-blur-md rounded-xl shadow-xl p-5 transition-all duration-500 hover:scale-103 hover:bg-emerald-50 hover:bg-opacity-80 hover:underline hover:shadow-2xl cursor-pointer">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-12 text-emerald-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
            </svg>

                <h3 class="font-semibold text-emerald-600 cursor-pointer">Tarik Saldo</h3>



        </div>


        <div
            class="flex flex-1 max-w-full lg:max-w-120 items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8 hover:scale-103 hover:bg-emerald-50 hover:bg-opacity-80 transition duration-500">
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
            class="flex flex-1 max-w-full lg:max-w-120 items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8 hover:scale-103 hover:bg-emerald-50 hover:bg-opacity-80 transition duration-500">
            <div class="flex flex-col items-start overflow-hidden max-w-[70%] w-full">
                <p class="text-sm font-regular text-gray-600 truncate w-full">Total Sampah</p>
                <p class="text-sm font-regular text-gray-600 truncate w-full">Terkumpul</p>
                <p class="font-semibold text-md truncate">{{ $totalBeratSampah . ' kg' }}</p>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('assets/flat-trash-can.png') }}" alt="" class="w-full h-auto">
            </div>
        </div>

        <a class="w-full flex-1 flex items-center justify-between gap-6 bg-white backdrop-blur-md rounded-xl shadow-xl p-8 max-w-full lg:max-w-120 hover:scale-103 hover:bg-emerald-50 hover:bg-opacity-80 transition duration-500"
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
