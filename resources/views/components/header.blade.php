<div x-data="{ menuOpened: false }" class="relative">
    <header class="flex justify-between items-center bg-white drop-shadow-md z-50 fixed w-full">
        <div class="px-4 py-4 space-x-2">
            <a href="/" class="flex items-center space-x-2 font-semibold text-lg">
                <img src="{{ asset('assets/bank-sampah-logo.svg') }}" alt="Logo bank sampah" class="w-6 h-6" />
                <span>Bank Sampah</span>
            </a>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden px-4" @click="menuOpened = !menuOpened">
            <button class="text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <!-- Desktop Navbar -->
        <nav class="hidden md:flex h-full text-sm font-medium pr-8">
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

    <!-- Mobile menu (hidden by default) -->
    <div x-cloak x-show="menuOpened" x-transition class="fixed top-16 inset-x-0 bg-white shadow-md z-40 md:hidden">
        <div class="flex flex-col py-3">
            @if (auth()->check())
                <a href="{{ route(auth()->user()->role.'.dashboard.index') }}"
                    class="px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-400">Dashboard</a>
            @endif
            <a href="/" class="px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-400">Beranda</a>
            <a href="/about-us" class="px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-400">Tentang Kami</a>
            <a href="/profile" class="px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-400">Profil</a>
        </div>
    </div>

    <div class="py-8"></div>
</div>
