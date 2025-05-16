<div x-data="{ sidebarOpen: false }" class="relative">

    <header class="flex justify-between items-center bg-white drop-shadow-md z-50 fixed w-full">
        <div class="flex items-center px-4 py-4 space-x-2">
            @if(auth()->check())
                <button
                    @click="sidebarOpen = true"
                    class="p-2 text-emerald-600 hover:bg-gray-100 rounded-lg"
                >

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            @endif

            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2 font-semibold text-lg">
                <img src="{{ asset('/assets/bank-sampah-logo.svg') }}" alt="Logo bank sampah" class="w-6 h-6"/>
                <span>Bank Sampah</span>
            </a>
        </div>

        <!-- Navbar -->
        <nav class="flex h-full text-sm font-medium pr-8">
            <a href="#"
               class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Home</a>
            <a href="#"
               class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">About
                Us</a>
            <a href="#"
               class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Profile</a>
        </nav>
    </header>

    <div class="py-8"></div>
    @if(auth()->check())
        <!-- Overlay -->
        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 bg-black/50 z-40"
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->

        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed text-white top-0 left-0 w-90 h-full bg-emerald-900 @if(auth()->user()->role === 'admin') bg-gray-800 @endif shadow-lg z-50 p-8 transform"
            @click.away="sidebarOpen = false"
        >
            <a href="{{ route(auth()->user()->role.'.dashboard.profile') }}">
                <div class="flex items-center mb-4 gap-6">
                    <div class="rounded-full border-2">
                        <img src="{{ asset('/avatars/default.jpg') }}"
                             alt="{{ auth()->user()->nama_depan . ' profle picture' }}" class="rounded-full w-18 h-18">
                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="text-white text-lg font-semibold">{{ auth()->user()->nama_depan.' '.auth()->user()->nama_belakang }}</h1>
                        <p class="text-gray-200 text-xs font-light">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </a>
            <ul class="space-y- mt-6">
                <li><a href="#" class="block px-2 py-1 hover:underline rounded">Dashboard</a></li>
                <li><a href="#" class="block px-2 py-1 hover:underline rounded">Transaksi</a></li>
                <li><a href="#" class="block px-2 py-1 hover:underline rounded">Keluar</a></li>
            </ul>
        </div>
    @endif
</div>
