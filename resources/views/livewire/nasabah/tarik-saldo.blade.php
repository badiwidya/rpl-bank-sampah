<div x-data="{ payment: @entangle('paymentMethod'), confirm: false }" class="w-full h-full flex flex-col md:flex-row">
    <div class="flex flex-col w-full md:w-[60%]">
        <h2 class="font-semibold text-base sm:text-lg mb-3 sm:mb-4">Buat Permohonan Penarikan Saldo</h2>

        <div class="flex flex-wrap justify-start items-center gap-2 mb-4 sm:mb-8">
            <div @click="payment = 'Gopay'"
                :class="payment === 'Gopay' ? 'grayscale-0 shadow-lg scale-105' : 'grayscale-100'"
                class="w-16 sm:w-18 h-7 sm:h-8 active:scale-100 active:shadow-none overflow-hidden p-1.5 sm:p-2 border-1 border-gray-300 rounded-lg sm:rounded-xl hover:shadow-lg hover:scale-105 transition duration-300 hover:cursor-pointer hover:grayscale-0">
                <img src="{{ asset('assets/gopay.svg') }}" alt="Gopay" class="object-cover">
            </div>
            <div @click="payment = 'Dana'"
                :class="payment === 'Dana' ? 'grayscale-0 shadow-lg scale-105' : 'grayscale-100'"
                class="w-16 sm:w-18 h-7 sm:h-8 active:scale-100 active:shadow-none overflow-hidden p-1.5 sm:p-2 border-1 border-gray-300 rounded-lg sm:rounded-xl hover:shadow-lg hover:scale-105 transition duration-300 hover:cursor-pointer hover:grayscale-0">
                <img src="{{ asset('assets/dana.svg') }}" alt="Dana" class="object-cover">
            </div>
            <div @click="payment = 'OVO'"
                :class="payment === 'OVO' ? 'grayscale-0 shadow-lg scale-105' : 'grayscale-100'"
                class="w-16 sm:w-18 h-7 sm:h-8 active:scale-100 active:shadow-none overflow-hidden p-1.5 sm:p-2 border-1 border-gray-300 rounded-lg sm:rounded-xl hover:shadow-lg hover:scale-105 transition duration-300 hover:cursor-pointer hover:grayscale-0">
                <img src="{{ asset('assets/ovo.svg') }}" alt="OVO" class="object-cover">
            </div>
            <div @click="payment = 'LinkAja'"
                :class="payment === 'LinkAja' ? 'grayscale-0 shadow-lg scale-105' : 'grayscale-100'"
                class="w-16 sm:w-18 h-7 sm:h-8 active:scale-100 active:shadow-none overflow-hidden p-1.5 sm:p-2 border-1 border-gray-300 rounded-lg sm:rounded-xl hover:shadow-lg hover:scale-105 transition duration-300 hover:cursor-pointer hover:grayscale-0">
                <img src="{{ asset('assets/linkaja.png') }}" alt="Linkaja" class="object-cover">
            </div>
        </div>
        <div class="flex flex-col">
            <label class="text-xs sm:text-sm">Nominal</label>
            <div
                class="flex items-center border-gray-300 border rounded-md pl-2 sm:pl-3 focus-within:ring-2 focus-within:ring-emerald-400 transition duration-300 @error('withdrawAmount')
                        border-red-400 focus-within:ring-red-400
                    @enderror">
                <span class="text-gray-700 text-sm select-none">Rp.</span>
                <input type="number" wire:model.live.debounce.300ms="withdrawAmount" placeholder="Masukkan nominal..."
                    min="10000"
                    class="p-1.5 sm:p-2 border-0 w-full border-gray-400 rounded-md placeholder:text-xs sm:placeholder:text-sm text-xs sm:text-sm focus:outline-none">
            </div>
            @error('withdrawAmount')
                <div class="text-xs text-red-400">{{ $message }}</div>
            @enderror

            <label class="mt-3 sm:mt-4 text-xs sm:text-sm">No. E-wallet</label>
            <input type="tel" wire:model.blur="ewalletNumber" placeholder="Masukkan nomor e-wallet..."
                min="10000"
                class="p-1.5 sm:p-2 w-full border-1 border-gray-300 rounded-md placeholder:text-xs sm:placeholder:text-sm text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('ewalletNumber')
                        border-red-400 focus-within:ring-red-400
                    @enderror">
            @error('ewalletNumber')
                <div class="text-xs text-red-400">{{ $message }}</div>
            @enderror
            <div class="mt-4 sm:mt-8 mb-3 sm:mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-2 sm:p-4 rounded-md shadow-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-500 mr-1.5 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs sm:text-sm font-medium text-gray-700">Perhatian</p>
                </div>
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-600">
                    Penarikan saldo akan diproses dalam <span class="font-bold text-emerald-600">1x24 jam</span> setelah permintaan diajukan.
                </p>
            </div>

            <div x-cloak x-show="confirm" class="bg-gray-50 p-3 sm:p-4 rounded-lg mb-3 sm:mb-4 border border-gray-300">
                <h3 class="text-sm sm:text-md font-semibold mb-1 sm:mb-2">Konfirmasi Penarikan</h3>
                <p class="mb-3 sm:mb-4 text-xs sm:text-sm text-gray-700">Apakah Anda yakin ingin melakukan penarikan saldo? Pastikan data
                    Anda telah sesuai, karena bisa saja admin mengirimkan ke nomor yang salah.</p>

                <div class="flex justify-end space-x-2 sm:space-x-3">
                    <button type="button"
                        class="px-2 sm:px-3 py-1 text-xs sm:text-sm hover:cursor-pointer rounded bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold"
                        @click="confirm = false">
                        Batal
                    </button>
                    <button type="button"
                        class="px-2 sm:px-3 py-1 text-xs sm:text-sm hover:cursor-pointer rounded bg-emerald-600 hover:bg-emerald-700 text-white font-semibold"
                        wire:click="action"
                        @click="confirm = false">
                        Konfirmasi
                    </button>
                </div>
            </div>

            <button x-show="!confirm" type="button" @click="confirm = true"
                class="py-1.5 sm:py-2 bg-emerald-600 text-white text-xs sm:text-sm hover:bg-emerald-700 hover:cursor-pointer rounded-md transition duration-300">
                Ajukan Penarikan
            </button>
        </div>
    </div>
    <div class="flex h-auto w-full md:w-[40%] justify-center pt-4 sm:pt-6 md:pt-8 mt-4 md:mt-0">
        <div class="w-full sm:w-[80%] md:h-[70%] border-1 border-gray-300 rounded-lg sm:rounded-xl shadow-lg p-3 sm:p-4 flex flex-col">
            <div class="flex items-center w-full justify-between">
                <div class="flex flex-col text-left overflow-hidden">
                    <p class="text-sm sm:text-md font-semibold truncate">{{ $user->nama_depan . ' ' . $user->nama_belakang }}</p>
                    <p class="text-xs sm:text-sm text-gray-600">{{ $ewalletNumber }}</p>
                    <p class="text-xs sm:text-sm text-gray-600 truncate">Rp {{ number_format($user->profile->saldo, 0, ',', '.') }}</p>
                </div>
                <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 border-1 border-gray-300 rounded-full overflow-hidden flex-shrink-0">
                    <img src="{{ asset($user->avatar_url) }}" alt="{{ $user->nama_depan }}'s profile picture"
                        class="w-full h-full object-cover">
                </div>
            </div>
            <div class="flex h-full justify-center items-center">
                <img :src="`/assets/${payment === 'LinkAja' ? 'linkaja.png' : payment.toLowerCase() + '.svg'}`"
                    :alt="payment" class="max-h-20 sm:max-h-24 md:max-h-32 max-w-32 sm:max-w-40 md:max-w-48 object-contain">
            </div>
        </div>
    </div>
</div>
