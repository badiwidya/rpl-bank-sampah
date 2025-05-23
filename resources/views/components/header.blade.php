<div class="relative">

    <header class="flex justify-between items-center bg-white drop-shadow-md z-50 fixed w-full">
        <div class="px-4 py-4 space-x-2">
            <a href="/" class="flex items-center space-x-2 font-semibold text-lg">
                <img src="{{ asset('assets/bank-sampah-logo.svg') }}" alt="Logo bank sampah" class="w-6 h-6" />
                <span>Bank Sampah</span>
            </a>
        </div>

        <!-- Navbar -->
        <nav class="flex h-full text-sm font-medium pr-8">
            @if (auth()->check())
                <a href="{{ route(auth()->user()->role.'.dashboard.index') }}"
                    class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Dashboard</a>
            @endif
            <a href="/"
                class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Beranda</a>
            <a href="/about-us"
                class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Tentang
                Kami</a>
            <a href="/profile"
                class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Profil</a>
        </nav>
    </header>

    <div class="py-8"></div>
</div>
