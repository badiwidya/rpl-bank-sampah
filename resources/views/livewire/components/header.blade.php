<div x-data="{ sidebarOpen: false }" class="relative">

    <header class="flex justify-between items-center bg-white drop-shadow-md z-50 fixed w-full">
        <div class="flex items-center px-4 py-4 space-x-4">
                <button
                    @click="sidebarOpen = true"
                    class="p-2 text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg cursor-pointer transition duration-300"
                >

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

            <!-- Logo -->
            <a href="{{ route($user->role.'.dashboard.index') }}" class="flex items-center space-x-2 font-semibold text-lg">
                <img src="{{ asset('assets/bank-sampah-logo.svg') }}" alt="Logo bank sampah" class="w-6 h-6"/>
                <span>Bank Sampah</span>
            </a>
        </div>

        <!-- Navbar -->
        <nav class="flex h-full text-sm font-medium pr-8">
            <a href="/"
               class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Beranda</a>
            <a href="/about-us"
               class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Tentang Kami</a>
            <a href="/profile"
               class="px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Profil</a>
        </nav>
    </header>

    <div class="py-8"></div>
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
            x-data="{ role: '{{ $user->role }}' }"
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed text-white top-0 left-0 w-90 h-full shadow-lg z-50 p-8 transform"
            :class="{
                'bg-emerald-900': role === 'nasabah',
                'bg-gray-800': role === 'admin'
            }"
            @click.away="sidebarOpen = false"
        >
            <a href="{{ route($user->role.'.dashboard.profile') }}">
                <div class="flex items-center mb-4 gap-6">
                    <div class="rounded-full border-1 border-gray-300 w-18 h-18 overflow-hidden">
                        <img src="{{ asset($user->avatar_url) }}"
                             alt="{{ $user->nama_depan . ' profle picture' }}" class="object-cover h-full w-full">
                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="text-white text-lg font-semibold">{{ $user->nama_depan.' '.$user->nama_belakang }}</h1>
                        <p class="text-gray-200 text-sm font-light">{{ $user->role === 'admin' ? $user->email : 'Rp ' . number_format($user->profile->saldo, 2, ',', '.') }}</p>
                    </div>
                </div>
            </a>
            <ul class="space-y- mt-6">
                <li><a href="{{ route($user->role.'.dashboard.index') }}" class="block px-2 py-1 hover:underline rounded" wire:navigate>Dashboard</a></li>
                <li><a href="{{ route($user->role.'.dashboard.profile') }}" class="block px-2 py-1 hover:underline rounded" wire:navigate>Pengaturan Profil</a></li>
                <li><a href="{{  route($user->role.'.dashboard.sampah') }}" class="block px-2 py-1 hover:underline rounded" wire:navigate>Katalog Sampah</a></li>
                <li><a href="{{  route($user->role.'.dashboard.riwayat') }}" class="block px-2 py-1 hover:underline rounded" wire:navigate>Riwayat Transaksi</a></li>
                
                <li>
                    <form id="logout-submit" action="{{  route('auth.logout') }}" method="post">
                        @csrf
                        <a @click="document.getElementById('logout-submit').submit()" class="block px-2 py-1 hover:underline rounded cursor-pointer">Keluar</a>
                    </form>
                </li>
            </ul>
        </div>
</div>
