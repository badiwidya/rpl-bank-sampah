<div class="flex justify-center bg-gradient-to-b from-emerald-50 to-emerald-200 min-h-full min-w-full">
    <div class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-4 sm:p-6 md:p-8 rounded-xl shadow-xl w-full max-w-2/3 my-8 md:my-16 mx-4 sm:mx-8">

        <section class="mb-4">
            <h1 class="font-medium text-xl sm:text-2xl">Pengaturan Profil</h1>
        </section>

        <form wire:submit.prevent="update">
            <section class="mb-6 sm:mb-8">
                <h3 class="font-light text-md text-gray-600 mb-3 sm:mb-4">Foto Profil</h3>
                <div class="flex flex-col sm:flex-row">
                    <div class="rounded-full border-1 border-gray-400 overflow-hidden w-20 h-20 sm:w-24 sm:h-24 mx-auto sm:mx-0 sm:mr-4 mb-4 sm:mb-0">
                        @if ($image && str_starts_with($image->getMimeType(), 'image/'))
                            <img src="{{ asset($image->temporaryUrl()) }}" alt="preview profile picture"
                                class="object-cover w-full h-full">
                        @else
                            <img src="{{ asset($user->avatar_url) }}"
                                alt="{{ $user->nama_depan . ' profile picture' }}"
                                class="object-cover w-full h-full">
                        @endif
                    </div>
                    <div class="flex flex-col items-center sm:justify-center gap-2">
                        <button type="button" @click="$refs.fileInput.click()"
                            class="border-emerald-600 text-emerald-600 py-2 w-36 border-1 rounded-3xl text-sm hover:text-white hover:cursor-pointer hover:bg-emerald-700 transition duration-300">Unggah
                            Foto Baru</button>
                        @if ($user->avatar_url !== 'avatars/default.png')
                            <button type="button" wire:click="isDelete = true"
                                class="border-red-600 border-1 text-red-600 hover:text-white py-2 w-36 rounded-3xl text-sm hover:cursor-pointer hover:bg-red-600 transition duration-300">Hapus
                                Foto Profil</button>
                        @endif
                    </div>
                </div>
                @error('image')
                    <div class="text-red-500 text-xs my-1 text-center sm:text-left sm:self-end">{{ $message }}</div>
                @enderror
                <input x-ref="fileInput" type="file" wire:model="image" accept=".jpeg,.jpg,.png" class="hidden">
            </section>

            <section>
                <h3 class="font-regular text-lg sm:text-xl text-black mb-3 sm:mb-4">Informasi Personal</h3>
                <div class="flex flex-col md:flex-row md:gap-8 mb-4">
                    <!-- Nama depan -->
                    <div class="flex-1 mb-4 md:mb-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="firstName">Nama Depan</label>
                        <input id="firstName" name="nama_depan" type="text" wire:model.defer="nama_depan"
                            placeholder="Masukkan nama depan Anda..."
                            class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('nama_depan') border-red-500 focus:ring-red-500 @enderror" />
                        @error('nama_depan')
                            <div class="text-red-500 text-xs my-1 self-end">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Belakang -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="lastName">Nama Belakang</label>
                        <input id="lastName" name="nama_belakang" type="text" wire:model.defer="nama_belakang"
                            placeholder="Masukkan nama belakang Anda..."
                            class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('nama_belakang') border-red-500 focus:ring-red-500 @enderror" />
                        @error('nama_belakang')
                            <div class="text-red-500 text-xs my-1 self-end">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:gap-8 mb-4">
                    <div class="flex-1 mb-4 md:mb-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Alamat Email</label>
                        <input id="email" name="email" type="email" wire:model.defer="email"
                            placeholder="Masukkan alamat email Anda..."
                            class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('email') border-red-500 focus:ring-red-500 @enderror" />
                        @error('email')
                            <div class="text-red-500 text-xs my-1 self-end">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="tel">No. Telepon</label>
                        <input id="tel" name="no_telepon" type="tel" wire:model.defer="no_telepon"
                            placeholder="Masukkan nomor telepon Anda..."
                            class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('no_telepon') border-red-500 focus:ring-red-500 @enderror" />
                        @error('no_telepon')
                            <div class="text-red-500 text-xs my-1 self-end">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </section>

            @if ($mode === 'nasabah')
                <section class="flex flex-col md:flex-row md:gap-8 mb-4">
                    <div x-data="{ open: false, selected: @entangle('metode_pembayaran_utama') }" class="relative flex-1 mb-4 md:mb-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran Utama</label>

                        <!-- Dropdown Trigger -->
                        <div @click="open = !open"
                            class="w-full px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-800 cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-400 @error('metode_pembayaran_utama')
                                ring-2 ring-red-500
                            @enderror transition duration-300"
                            :class="{ 'ring-2 ring-emerald-400': open }">
                            <span x-text="selected || 'Pilih metode pembayaran'"></span>
                            <svg class="w-4 h-4 inline-block float-right mt-1 text-gray-600" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Dropdown Options -->
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                            <template x-for="option in ['Gopay', 'Dana', 'OVO', 'LinkAja']" :key="option">
                                <div @click="selected = option; open = false"
                                    class="px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 cursor-pointer transition">
                                    <span x-text="option"></span>
                                </div>
                            </template>
                        </div>
                        @error('metode_pembayaran_utama')
                            <div class="text-red-500 text-xs my-1 self-end">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex-1"></div>
                </section>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" wire:model.defer="alamat" rows="3"
                        class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('alamat') border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Masukkan alamat lengkap..."></textarea>
                </div>
            @endif

            <section class="mt-6 mb-6">
                <h3 class="font-regular text-lg sm:text-xl text-black mb-3 sm:mb-4">Keamanan</h3>
                <a href="{{ route($user->role . '.dashboard.password') }}" wire:navigate
                    class="block w-fit px-6 sm:px-8 py-2 bg-emerald-600 rounded-2xl text-sm hover:bg-emerald-700 hover:cursor-pointer text-white">Ganti
                    Password</a>
            </section>

            <section class="flex justify-center sm:justify-end mt-8 md:mt-12">
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-emerald-600 rounded-xl text-white hover:bg-emerald-700 hover:cursor-pointer">Simpan
                    Perubahan</button>
            </section>
        </form>
    </div>

    <div x-cloak x-show="$wire.isDelete" class="fixed inset-0 bg-black/50 z-50" x.transition.opacity></div>

    <div x-cloak wire:show="isDelete"
        class="flex flex-col fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-lg p-4 sm:p-6 z-50 mx-4 w-11/12 max-w-md"
        @click.away="$wire.isDelete = false">
        <h3 class="text-lg font-semibold mb-3 sm:mb-4">Konfirmasi Hapus</h3>
        <p class="mb-4 sm:mb-6 text-gray-700">Apakah Anda yakin ingin menghapus foto profil Anda? Tindakan ini tidak dapat
            dibatalkan.</p>

        <div class="flex justify-end space-x-3">
            <button type="button"
                class="px-3 sm:px-4 py-2 hover:cursor-pointer rounded bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold text-sm"
                @click="$wire.isDelete = false">
                Batal
            </button>

            <button type="button"
                class="px-3 sm:px-4 py-2 hover:cursor-pointer rounded bg-red-600 hover:bg-red-700 text-white font-semibold text-sm"
                wire:click="deleteAvatar">
                Hapus
            </button>
        </div>
    </div>

    @if (session('email'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    Toaster.success('Email Anda berhasil diganti!');
                }, 500);
            });
        </script>
    @endif
</div>
