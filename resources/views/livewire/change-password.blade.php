<div class="flex justify-center items-center bg-gradient-to-b from-emerald-50 to-emerald-200 min-h-full min-w-full px-4 py-6 sm:py-8 md:py-10">
    <div class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-5 sm:p-6 md:p-8 rounded-xl shadow-xl w-full max-w-md">
        <h1 class="font-semibold text-lg sm:text-xl mb-4 sm:mb-6 text-center sm:text-left">Ganti Password</h1>
        <form wire:submit.prevent="update">
            <div class="mb-4">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Password Lama</label>
                <div x-data="{ open: false }" class="relative">
                    <input id="currentPassword" :type="open ? 'text' : 'password'"
                        wire:model.defer="currentPassword" placeholder="Masukkan password lama Anda..."
                        class="w-full px-3 sm:px-4 py-2 text-sm placeholder:text-xs sm:placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('currentPassword') border-red-500 focus:ring-red-500 @enderror" />
                    <div @click="open = !open"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer toggle-password">
                        <!-- Eye Open -->
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <!-- Eye Closed -->
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </div>
                </div>

                @error('currentPassword')
                    <div class="text-red-500 text-xs mt-1 mb-1 sm:my-1 sm:self-end">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1" for="password">Password Baru</label>
                <div x-data="{ open: false }" class="relative">
                    <input id="password" :type="open ? 'text' : 'password'"
                        wire:model.defer="password" placeholder="Masukkan password baru Anda..."
                        class="w-full px-3 sm:px-4 py-2 text-sm placeholder:text-xs sm:placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('password') border-red-500 focus:ring-red-500 @enderror" />
                    <div @click="open = !open"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer toggle-password">
                        <!-- Eye Open -->
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <!-- Eye Closed -->
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </div>
                </div>

                @error('password')
                    <div class="text-red-500 text-xs mt-1 mb-1 sm:my-1 sm:self-end">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1" for="currentPassword">Konfirmasi Password Baru</label>
                <div x-data="{ open: false }" class="relative">
                    <input id="password_confirmation" :type="open ? 'text' : 'password'"
                        wire:model.defer="password_confirmation" placeholder="Konfirmasi password baru Anda..."
                        class="w-full px-3 sm:px-4 py-2 text-sm placeholder:text-xs sm:placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('password') border-red-500 focus:ring-red-500 @enderror" />
                    <div @click="open = !open"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer toggle-password">
                        <!-- Eye Open -->
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <!-- Eye Closed -->
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </div>
                </div>

            </div>
            <div class="flex justify-center sm:justify-end mt-4 sm:mt-6">
                <button type="submit" class="bg-emerald-600 text-white text-sm sm:text-base py-2 px-4 sm:px-5 rounded-lg hover:bg-emerald-700 hover:cursor-pointer min-w-[100px] sm:min-w-[120px] focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50 transition-all duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>
