<div x-data="{ sidebarOpen: false }" class="relative">

    <header class="flex justify-between items-center bg-white drop-shadow-md z-50 fixed w-full">
        <div class="flex items-center px-3 py-3 space-x-3 md:px-4 md:py-4 md:space-x-4">
            <button @click="sidebarOpen = true"
                class="p-2 text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg cursor-pointer transition duration-300">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route($user->role . '.dashboard.index') }}"
                class="flex items-center space-x-2 font-semibold text-base md:text-lg">
                <img src="{{ asset('assets/bank-sampah-logo.svg') }}" alt="Logo bank sampah" class="w-6 h-6" />
                <span>Bank Sampah</span>
            </a>
        </div>

        <!-- Navbar -->
        <nav class="hidden md:flex h-full text-sm font-medium pr-6 lg:pr-8">
            <a href="/"
                class="px-3 lg:px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Beranda</a>
            <a href="/about-us"
                class="px-3 lg:px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Tentang
                Kami</a>
            <a href="/profile"
                class="px-3 lg:px-4 flex items-center text-gray-700 hover:text-emerald-400 hover:underline transition duration-300">Profil</a>
        </nav>
    </header>

    <div class="py-6 md:py-8"></div>

    <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-40"
        @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <div x-cloak x-data="{ role: '{{ $user->role }}', activeMenu: '{{ request()->route()->getName() }}' }" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed text-white top-0 left-0 w-80 h-full shadow-2xl z-50 transform flex flex-col sm:w-84 lg:w-90"
        :class="{
            'bg-emerald-800': role === 'nasabah',
            'bg-gray-700': role === 'admin'
        }"
        @click.away="sidebarOpen = false">

        <!-- User Profile Section -->
        <div class="flex items-center p-4 gap-3 border-b border-white/10 sm:p-5 sm:gap-4 lg:p-6">
            <a href="{{ route('nasabah.dashboard.profile') }}" wire:navigate>
                <div
                    class="rounded-full border-2 border-white/30 w-14 h-14 overflow-hidden flex-shrink-0 shadow-md hover:border-white hover:scale-105 transition duration-300 sm:w-16 sm:h-16">
                    <img src="{{ asset($user->avatar_url) }}" alt="{{ $user->nama_depan . ' profile picture' }}"
                        class="object-cover h-full w-full">
                </div>
            </a>
            <div class="flex flex-col gap-1 overflow-hidden min-w-0">
                <h1 class="text-white text-lg font-semibold truncate">
                    {{ $user->nama_depan . ' ' . $user->nama_belakang }}</h1>
                <a class="hover:underline flex items-center"
                    href="{{ $user->role === 'nasabah' ? route('nasabah.dashboard.index') . '?tarik-saldo=true' : route('admin.dashboard.profile') }}"
                    wire:navigate>
                    <p class="text-gray-200 text-sm">
                        @if ($user->role === 'admin')
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <span class="truncate">{{ $user->email }}</span>
                            </span>
                        @else
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium truncate">Rp
                                    {{ number_format($user->profile->saldo, 0, ',', '.') }}</span>
                            </span>
                        @endif
                    </p>
                </a>
                <div class="text-xs text-white/70">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/20 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 flex-shrink-0" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 005 10a1 1 0 10-2 0c0 .93.216 1.807.586 2.586A3 3 0 005 16h10a3 3 0 002.414-1.414c.37-.779.586-1.656.586-2.586a1 1 0 10-2 0 6.01 6.01 0 00-.432 2 1 1 0 01-1 1H5a1 1 0 01-1-1 6.01 6.01 0 00-.432-2A5 5 0 0010 11z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414-1.414L8.586 10l-4.95-4.95A1 1 0 115.05 3.636L10 8.586z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto p-4">
            <div class="text-xs font-semibold uppercase tracking-wider text-white/50 mb-3 pl-4">Menu Utama</div>
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route($user->role . '.dashboard.index') }}" wire:navigate
                        :class="activeMenu === '{{ $user->role }}.dashboard.index' ? 'bg-white/20 text-white' :
                            'text-white/80 hover:bg-white/10'"
                        class="flex items-center px-4 py-3 rounded-lg transition duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span class="text-base">Dashboard</span>
                    </a>
                </li>

                <!-- Profile Settings -->
                <li>
                    <a href="{{ route($user->role . '.dashboard.profile') }}" wire:navigate
                        :class="activeMenu === '{{ $user->role }}.dashboard.profile' ? 'bg-white/20 text-white' :
                            'text-white/80 hover:bg-white/10'"
                        class="flex items-center px-4 py-3 rounded-lg transition duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-base truncate">Pengaturan Profil</span>
                    </a>
                </li>

                <!-- Waste Catalog -->
                <li>
                    <a href="{{ route($user->role . '.dashboard.sampah') }}" wire:navigate
                        :class="activeMenu === '{{ $user->role }}.dashboard.sampah' ? 'bg-white/20 text-white' :
                            'text-white/80 hover:bg-white/10'"
                        class="flex items-center px-4 py-3 rounded-lg transition duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-base">Katalog Sampah</span>
                    </a>
                </li>

                <!-- Waste Deposits / Deposit History -->
                <li>
                    <a href="{{ route($user->role . '.dashboard.setoran') }}" wire:navigate
                        :class="activeMenu === '{{ $user->role }}.dashboard.setoran' ? 'bg-white/20 text-white' :
                            'text-white/80 hover:bg-white/10'"
                        class="flex items-center px-4 py-3 rounded-lg transition duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                clip-rule="evenodd" />
                        </svg>
                        <span
                            class="text-base truncate">{{ $user->role === 'admin' ? 'Setoran Sampah' : 'Riwayat Setoran' }}</span>
                    </a>
                </li>

                <!-- Withdrawal History -->
                <li>
                    <a href="{{ route($user->role . '.dashboard.penarikan') }}" wire:navigate
                        :class="activeMenu === '{{ $user->role }}.dashboard.penarikan' ? 'bg-white/20 text-white' :
                            'text-white/80 hover:bg-white/10'"
                        class="flex items-center px-4 py-3 rounded-lg transition duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                        </svg>
                        <span
                            class="text-base truncate">{{ $user->role === 'nasabah' ? 'Riwayat Penarikan' : 'Penarikan Saldo' }}</span>
                    </a>
                </li>

                @if ($user->role === 'admin')
                    <!-- Manage Posts -->
                    <li>
                        <a href="{{ route($user->role . '.dashboard.post') }}" wire:navigate
                            :class="activeMenu === '{{ $user->role }}.dashboard.post' ? 'bg-white/20 text-white' :
                                'text-white/80 hover:bg-white/10'"
                            class="flex items-center px-4 py-3 rounded-lg transition duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <span class="text-base">Kelola Postingan</span>
                        </a>
                    </li>
                @endif
            </ul>

            @if ($user->role === 'nasabah')
                <div class="text-xs font-semibold uppercase tracking-wider text-white/50 mt-8 mb-3 pl-4">Transaksi
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('nasabah.dashboard.index') }}?tarik-saldo=true" wire:navigate
                            class="flex items-center px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-base">Tarik Saldo</span>
                        </a>
                    </li>
                </ul>
            @endif
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-white/10">
            <form id="logout-submit" action="{{ route('auth.logout') }}" method="post">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414a1 1 0 00-.293-.707L11.414 2.414A1 1 0 0010.707 2H4a1 1 0 00-1 1zm9 2.5V5a.5.5 0 01.5-.5h2a.5.5 0 01.5.5v9a.5.5 0 01-.5.5h-9a.5.5 0 01-.5-.5V4a.5.5 0 01.5-.5h6a.5.5 0 01.354.146l1.853 1.854a.5.5 0 01.146.353v.793zM9 6a1 1 0 00-1 1v1H7a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-base">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>
