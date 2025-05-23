<x-layouts.app title="Masuk - Bank Sampah">

        <!-- Main Content -->
        <div class="flex flex-col md:flex-row h-full">
            <!-- Left Panel -->
            <div
                class="w-full md:w-1/2 bg-gradient-to-b from-[#0eb784] to-[#003d26] flex flex-col items-center justify-center text-white px-4 sm:px-6 md:px-8 py-8 md:py-0">
                <img src="{{ asset('assets/earth-tree.svg') }}" alt="Earth with Trees" class="w-40 sm:w-56 md:w-64 lg:w-72 mb-6 sm:mb-10 md:mb-14"/>
                <p class="text-center text-xs sm:text-sm max-w-md font-light">
                    "Dengan memanfaatkan bank sampah, kita ikut berperan aktif dalam menjaga ekosistem dan memastikan
                    bumi tetap lestari untuk generasi mendatang."
                </p>
            </div>

            <!-- Right Panel -->
            <div class="w-full md:w-1/2 flex items-center justify-center bg-white py-8 md:py-0">
                <div
                    class="bg-white p-4 sm:p-6 md:p-8 rounded-lg sm:rounded-xl shadow-xl sm:shadow-2xl border border-gray-100 w-[85%] sm:w-[70%] md:w-80 text-center hover:shadow-emerald-200 hover:scale-[1.02] sm:hover:scale-105 transition-all duration-300">
                    <div class="flex justify-center mb-3 sm:mb-4">
                        <img src="https://img.icons8.com/ios-filled/50/0eb784/user-male-circle.png" alt="User Icon"
                             class="w-10 h-10 sm:w-12 sm:h-12"/>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold">Login Sebagai</h2>
                    <p class="text-gray-500 text-xs sm:text-sm mb-4 sm:mb-6">Akses Akun Bank Sampah</p>

                    <!-- Admin Button as Anchor -->
                    <a href="{{ route('admin.login.show') }}"
                       class="block bg-gray-800 text-white text-xs sm:text-sm font-medium w-full py-1.5 sm:py-2 rounded-md mb-2 sm:mb-3 hover:bg-gray-700 transition">Admin</a>

                    <!-- Pengguna Button -->
                    <a href="{{ route('nasabah.login.show') }}"
                       class="block bg-emerald-600 text-white text-xs sm:text-sm font-medium w-full py-1.5 sm:py-2 rounded-md hover:bg-emerald-700 transition">Nasabah</a>

                    <p class="mt-4 sm:mt-6 text-xs text-gray-500">
                        Tidak Memiliki Akun? <a href="{{ route('nasabah.register.show') }}" class="text-emerald-600 hover:underline">Daftar Disini</a>
                    </p>
                </div>
            </div>
        </div>

</x-layouts.app>
