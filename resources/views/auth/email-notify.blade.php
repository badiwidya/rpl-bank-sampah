<x-layouts.app title="Verifikasi Email Anda">

    <div class="flex justify-center items-center h-full bg-gray-200">

        <div class="bg-white backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
            <h2 class="text-center text-xl font-semibold">Verifikasi Email Anda</h2>
            <p class="text-sm text-center my-4">
                Kami telah mengirim email verifikasi ke <strong>{{ auth()->user()->email }}</strong>. Silakan periksa
                kotak masuk Anda untuk menyelesaikan proses verifikasi.
            </p>
            <p class="text-sm mb-4 text-center text-gray-700">Tidak menerima pesan?</p>
            <form action="{{ route('mail.verification.resend') }}" method="post">
                @csrf
                <button type="submit"
                        class="block py-2 text-center w-full text-white rounded-md bg-emerald-600 hover:bg-emerald-700 transition cursor-pointer disabled:opacity-50 @if(session()->hasAny(['success', 'error'])) disabled:hover:bg-emerald-600 disabled:cursor-auto @endif"
                        @if(session()->hasAny(['success', 'error'])) disabled @endif >Kirim Ulang
                </button>
            </form>
            @if (session()->hasAny(['success', 'error']))

                <p id="timer" class="font-bold text-red-950 text-center text-sm mt-2">01:00</p>

                @if(session()->has('success'))
                    <div class="text-sm font-light text-emerald-500 text-center mt-2">{{ session('success') }}</div>
                @endif

                @if(session()->has('error'))
                    <div class="text-sm font-light text-red-500 text-center mt-2">{{ session('error') }}</div>
                @endif
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

                // Timer countdown
                let timer = 60;
                const timerElement = document.getElementById('timer');
                const interval = setInterval(() => {
                    timer--;
                    const minutes = Math.floor(timer / 60);
                    const seconds = timer % 60;
                    timerElement.innerHTML = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                    if (timer <= 0) {
                        clearInterval(interval);
                        button.disabled = false;

                    }
                }, 1000);

            });

        </script>
    @endpush

</x-layouts.app>
