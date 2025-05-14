{{--<!DOCTYPE html>--}}
{{--<html lang="id">--}}
{{--<head>--}}
{{--  <meta charset="UTF-8" />--}}
{{--  <meta name="viewport" content="width=device-width, initial-scale=1.0" />--}}
{{--  <title>Bank Sampah - Login</title>--}}
{{--  <script src="https://cdn.tailwindcss.com"></script>--}}
{{--</head>--}}

<x-layouts.app title="Masuk Nasabah - Bank Sampah">


    <!-- Login Form -->
    <div
        class="flex justify-center items-center h-full px-4 bg-cover bg-center"
        style="
            background-image:
                linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(0,61,38,1) 100%),
                url('{{ asset('assets/bg-login-nasabah.jpeg') }}');
        "
    >
        <div class="bg-white bg-opacity-90 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
            <div class="flex justify-center mb-6">
                <img src="https://img.icons8.com/ios-filled/50/0eb784/user-male-circle.png" alt="User Icon"
                     class="w-12 h-12"/>
            </div>
            @error('wrong_route')
            <div class="text-sm font-light text-red-500 text-center">{{ $message }}</div>
            @enderror
            <h2 class="text-xl font-semibold text-center">Masuk Sebagai Nasabah</h2>
            <p class="text-center text-sm text-gray-500 mb-6">Akses akun Bank Sampah Anda</p>

            <form action="{{ route('nasabah.login.submit') }}" method="POST">
                @csrf
                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email/No. Telepon</label>
                    <input type="text" placeholder="Masukkan Email/No. Telepon" name="login"
                           class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 @error('login') border-red-500 focus:ring-red-500 @enderror"/>
                    @error('login')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" placeholder="Masukkan Password" name="password"
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

                <!-- Remember me & forgot -->
                <div class="flex justify-between items-center mb-6 text-sm">
                    <label class="flex items-center space-x-2 text-gray-600">
                        <input type="checkbox" name="remember_me" class="form-checkbox text-green-600"/>
                        <span>Ingat saya</span>
                    </label>
                    <a href="{{ route('auth.password.request') }}" class="text-green-500 hover:underline">Lupa
                        Password?</a>
                </div>

                <!-- Login as Anchor -->
                <button type="submit"
                        class="block text-center w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition cursor-pointer">
                    Login
                </button>
            </form>

            <!-- Sign Up -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Belum punya akun? <a href="{{ route('nasabah.register.show') }}" class="text-green-600 hover:underline">Daftar
                    sekarang</a>
            </p>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const togglePassword = document.querySelector('.toggle-password');
                const passwordInput = document.querySelector('input[name="password"]');
                const eyeOpenIcon = document.querySelector('.eye-open');
                const eyeCloseIcon = document.querySelector('.eye-closed');

                togglePassword.addEventListener('click', function () {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeOpenIcon.classList.add('hidden');
                        eyeCloseIcon.classList.remove('hidden');
                    } else {
                        passwordInput.type = 'password';
                        eyeOpenIcon.classList.remove('hidden');
                        eyeCloseIcon.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush


</x-layouts.app>
