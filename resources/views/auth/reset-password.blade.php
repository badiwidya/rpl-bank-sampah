<x-layouts.app title="Verifikasi Email Anda">

    <div class="flex justify-center items-center h-full bg-gray-200">

        <div class="bg-white backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
            <h2 class="text-center text-xl font-semibold mb-4">Reset Password Anda</h2>
            <form action="{{ route('auth.password.update') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Alamat email</label>
                    <input id="email" name="email" type="email"
                           class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300  read-only:opacity-80 read-only:bg-gray-200"
                           value="{{ $email }}"
                           readonly
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password baru</label>
                    <div class="relative password-wrapper">
                        <input id="password" name="password" type="password" placeholder="Masukkan password baru Anda"
                               class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('password') border-red-500 focus:ring-red-500 @enderror"/>
                        <div class="absolute inset-y-0 right-3 flex items-center cursor-pointer toggle-password">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 eye-open"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                            </svg>


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


                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="confirmPassword">Konfirmasi
                        password baru</label>
                    <div class="relative password-wrapper">
                        <input id="confirmPassword" name="password_confirmation" type="password"
                               placeholder="Masukkan password baru Anda"
                               class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('password') border-red-500 focus:ring-red-500 @enderror"/>
                        <div
                            class="absolute inset-y-0 right-3 flex items-center cursor-pointer toggle-password">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 eye-open"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                            </svg>


                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 eye-closed hidden"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </div>
                    </div>
                </div>

                    <button type="submit"
                            class="block py-2 mt-6 text-center w-full text-white rounded-md bg-emerald-600 hover:bg-emerald-700 transition cursor-pointer disabled:opacity-50 @if(session()->hasAny(['success', 'error'])) disabled:hover:bg-emerald-600 disabled:cursor-auto @endif">
                        Ganti Password
                    </button>
            </form>

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
