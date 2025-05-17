<div class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-2/3 my-16">

    <section class="mb-4">
        <h1 class="font-medium text-2xl">Pengaturan Profil</h1>
    </section>
    
    <form>
        <section class="mb-8">
            <h3 class="font-light text-md text-gray-600 mb-4">Foto Profil</h3>
            <div class="flex">
                <div class="rounded-full border-1 border-gray-400 overflow-hidden w-24 h-24 mr-4">
                    <img src="{{ asset(auth()->user()->avatar_url) }}"
                        alt="{{ auth()->user()->nama_depan . ' profile picture' }}" class="object-cover w-full h-full">
                </div>
                <div class="flex flex-col items-center justify-center gap-2">
                    <button
                        class="border-emerald-600 text-emerald-600 py-2 w-36 border-1 rounded-3xl text-sm hover:text-white hover:cursor-pointer hover:bg-emerald-700 transition duration-300">Unggah
                        Foto Baru</button>
                    @if (auth()->user()->avatar_url !== 'avatars/default.jpg')
                        <button
                            class="border-red-600 border-1 text-red-600 hover:text-white py-2 w-36 rounded-3xl text-sm hover:cursor-pointer hover:bg-red-600 transition duration-300">Hapus
                            Foto Profil</button>
                    @endif
                </div>
            </div>
        </section>

        <section>
            <h3 class="font-regular text-xl text-black mb-4">Informasi Personal</h3>
            <div class="flex gap-8 mb-4">
                <!-- Nama depan -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="firstName">Nama Depan</label>
                    <input id="firstName" name="nama_depan" type="text"
                        class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('nama_depan') border-red-500 focus:ring-red-500 @enderror" />
                </div>

                <!-- Nama Belakang -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="lastName">Nama Belakang</label>
                    <input id="lastName" name="nama_belakang" type="text"
                        class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('nama_belakang') border-red-500 focus:ring-red-500 @enderror" />
                </div>
            </div>

            <div class="flex gap-8 mb-12">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Alamat Email</label>
                    <input id="email" name="email" type="email"
                        class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('email') border-red-500 focus:ring-red-500 @enderror" />
                </div>
                <div class="flex-1"></div>
            </div>

        </section>

        <section>
            <h3 class="font-regular text-xl text-black mb-4">Keamanan</h3>
            <button
                class="px-8 py-2 bg-emerald-600 rounded-2xl text-sm hover:bg-emerald-700 hover:cursor-pointer text-white">Ganti
                Password</button>
        </section>

        <section class="flex justify-end mt-12">
            <button type="submit"
                class="px-4 py-2 bg-emerald-600 rounded-xl text-white hover:bg-emerald-700 hover:cursor-pointer">Simpan
                Perubahan</button>
        </section>
    </form>
</div>
