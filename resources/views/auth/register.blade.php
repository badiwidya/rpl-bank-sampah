<x-layouts.app title="Daftar - Bank Sampah">
    <!-- Sign Up Form -->
    <div class="flex justify-center items-center h-full px-4 bg-cover bg-center"
         style="
            background-image:
                linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(0,61,38,1) 100%),
                url('{{ asset('assets/bg-login-nasabah.jpeg') }}');
        ">
        <div class="bg-white bg-opacity-90 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-lg my-12">
            <div class="flex justify-center mb-6">
                <img src="https://img.icons8.com/ios-filled/50/0eb784/user-male-circle.png" alt="User Icon"
                     class="w-12 h-12"/>
            </div>
            <h2 class="text-xl font-semibold text-center">Buat Akun Baru</h2>
            <p class="text-center text-sm text-gray-500 mb-6">Ayo bergabung menjadi nasabah sekarang!</p>
            <form class="mt-6" autocomplete="off" action="{{ route('nasabah.register.submit') }}" method="POST">
                @csrf
                <div class="flex space-x-4 mb-4">
                    <!-- Nama Depan -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="firstName">Nama Depan</label>
                        <input id="firstName" name="nama_depan" type="text" placeholder="John"
                               class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 @error('nama_depan') border-red-500 focus:ring-red-500 @enderror"
                               value="{{ old('nama_depan') }}"
                        />
                        @error('nama_depan')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Belakang -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="lastName">Nama Belakang</label>
                        <input id="lastName" name="nama_belakang" type="text" placeholder="Doe"
                               class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 @error('nama_belakang') border-red-500 focus:ring-red-500 @enderror"
                               value="{{ old('nama_belakang') }}"
                        />
                        @error('nama_belakang')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- No Handphone -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">No. Telepon</label>
                    <input id="phone" name="no_telepon" type="text" placeholder="08123456789"
                           class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 @error('no_telepon') border-red-500 focus:ring-red-500 @enderror"
                           value="{{ old('no_telepon') }}"
                    />
                    @error('no_telepon')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Alamat email</label>
                    <input id="email" name="email" type="email" placeholder="johndoe@example.com"
                           class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 @error('email') border-red-500 focus:ring-red-500 @enderror"
                           value="{{ old('email') }}"
                    />
                    @error('email')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
                    <div class="relative password-wrapper">
                        <input id="password" name="password" type="password" placeholder="Masukkan password Anda"
                               class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 @error('password') border-red-500 focus:ring-red-500 @enderror"/>
                        <div class="absolute inset-y-0 right-3 flex items-center cursor-pointer toggle-password">
                            <!-- Eye Open -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 eye-open"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                            </svg>

                            <!-- Eye Closed -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 eye-closed hidden"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </div>
                    </div>
                    @error('password')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="confirmPassword">Konfirmasi
                        Password</label>
                    <div class="relative password-wrapper">
                        <input id="confirmPassword" name="password_confirmation" type="password"
                               placeholder="Masukkan password Anda"
                               class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 @error('password') border-red-500 focus:ring-red-500 @enderror"/>
                        <div
                            class="absolute inset-y-0 right-3 flex items-center cursor-pointer toggle-password">
                            <!-- Eye Open -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 eye-open"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                            </svg>

                            <!-- Eye Closed -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 eye-closed hidden"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </div>
                    </div>
                </div>


                <!-- Sign Up Button -->
                <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition cursor-pointer">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun? <a href="{{ route('auth.login.choice') }}" class="text-green-600 hover:underline">Masuk
                    ke akun</a>
            </p>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.password-wrapper').forEach(wrapper => {
                    const togglePassword = wrapper.querySelector('.toggle-password');
                    const passwordInput = wrapper.querySelector('input[type="password"], input[type="text"]');
                    const eyeOpen = wrapper.querySelector('.eye-open');
                    const eyeClosed = wrapper.querySelector('.eye-closed');
                    togglePassword.addEventListener('click', function () {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        eyeOpen.classList.toggle('hidden');
                        eyeClosed.classList.toggle('hidden');
                    });


                })
            });
        </script>
    @endpush

</x-layouts.app>
