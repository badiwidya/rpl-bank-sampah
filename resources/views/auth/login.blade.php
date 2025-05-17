<x-layouts.app title="Masuk - Bank Sampah">

        <!-- Main Content -->
        <div class="flex h-full">
            <!-- Left Panel -->
            <div
                class="w-1/2 bg-gradient-to-b from-[#0eb784] to-[#003d26] flex flex-col items-center justify-center text-white px-8">
                <img src="{{ asset('assets/earth-tree.svg') }}" alt="Earth with Trees" class="w-72 mb-14"/>
                <p class="text-center text-sm max-w-md font-light">
                    "Dengan memanfaatkan bank sampah, kita ikut berperan aktif dalam menjaga ekosistem dan memastikan
                    bumi tetap lestari untuk generasi mendatang."
                </p>
            </div>

            <!-- Right Panel -->
            <div class="w-1/2 flex items-center justify-center bg-white">
                <div
                    class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100 w-80 text-center hover:shadow-emerald-200 transition">
                    <div class="flex justify-center mb-4">
                        <img src="https://img.icons8.com/ios-filled/50/0eb784/user-male-circle.png" alt="User Icon"
                             class="w-12 h-12"/>
                    </div>
                    <h2 class="text-lg font-semibold">Login Sebagai</h2>
                    <p class="text-gray-500 text-sm mb-6">Akses Akun Bank Sampah</p>

                    <!-- Admin Button as Anchor -->
                    <a href="{{ route('admin.login.show') }}"
                       class="block bg-gray-800 text-white w-full py-2 rounded-md mb-3 hover:bg-gray-700 transition">Admin</a>

                    <!-- Pengguna Button -->
                    <a href="{{ route('nasabah.login.show') }}"
                       class="block bg-emerald-600 text-white w-full py-2 rounded-md hover:bg-emerald-700 transition">Nasabah</a>

                    <p class="mt-6 text-xs text-gray-500">
                        Tidak Memiliki Akun? <a href="{{ route('nasabah.register.show') }}" class="text-emerald-600 hover:underline">Daftar Disini</a>
                    </p>
                </div>
            </div>
        </div>

</x-layouts.app>
