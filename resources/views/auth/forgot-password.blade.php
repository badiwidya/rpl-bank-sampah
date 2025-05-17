<x-layouts.app title="Lupa Password - Bank Sampah">

    <div class="flex justify-center items-center h-full bg-gray-200">

        <div class="bg-white backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
            <form action="{{ route('auth.password.email') }}" method="post">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Alamat email</label>
                    <input id="email" name="email" type="email" placeholder="johndoe@example.com"
                           class="w-full px-4 py-2 placeholder:text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('email') border-red-500 focus:ring-red-500 @enderror"
                           value="{{ old('email') }}"
                    />
                    @error('email')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit"
                        class="block py-2 text-center w-full text-white rounded-md bg-emerald-600 hover:bg-emerald-700 transition cursor-pointer disabled:opacity-50 @if(session()->has('status')) disabled:hover:bg-emerald-600 disabled:cursor-auto @endif"
                        @if(session()->has('status')) disabled @endif >Reset Password
                </button>
            </form>
            @if(session()->has('status'))
                <div class="text-sm font-light text-emerald-500 text-center mt-2">{{ session('status') }}</div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.querySelector('form');
                const button = form.querySelector('button');

                form.addEventListener('submit', function () {
                    button.innerHTML = 'Mengirim...';
                    button.disabled = true;
                });
            });

        </script>
    @endpush

</x-layouts.app>

