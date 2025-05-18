<div class="bg-gray-200 min-h-full min-w-full flex justify-center items-center">
    <div class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-[60%]">

        <div x-data="{ open: @entangle('isUserSelected') }" class="flex justify-between">
            <h1 class="text-lg font-semibold text-xl mb-8">Buat Setoran Baru</h1>
            <div x-show="open" x-cloak class="flex gap-2 items-center max-w-[30%]">
                <div class="h-12 w-12 flex-shrink-0 rounded-full border-1 border-gray-400 overflow-hidden">
                    <img src="{{ asset($selectedUser?->avatar_url) }}"
                        alt="{{ $selectedUser?->nama_depan . '\'s profile picture' }}"
                        class="object-cover w-full h-full">
                </div>
                <div class="flex flex-col overflow-hidden">
                    <p class="text-sm truncate whitespace-nowrap text-ellipsis overflow-hidden">
                        {{ $selectedUser?->nama_depan . ' ' . $selectedUser?->nama_belakang }}</p>
                    <p class="text-xs text-gray-600 truncate whitespace-nowrap text-ellipsis overflow-hidden">{{ $selectedUser?->email }}</p>
                </div>
            </div>
        </div>


        <div class="relative w-[50%]" x-data="{ open: false }" @click.away="open = false">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Nasabah</label>

            <input type="text" wire:model.live.debounce.100ms="searchuser" @focus="open = true"
                placeholder="Ketik nomor telepon..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300">

            <div x-show="open" x-cloak x-transition
                class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                @forelse($this->filteredUsers() as $user)
                    <div wire:click="selectUser('{{ $user->no_telepon }}')" @click="open = false"
                        class="px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 cursor-pointer transition">
                        {{ $user->nama_depan . ' ' . $user->nama_belakang }} - {{ $user->no_telepon }}
                    </div>
                @empty
                    <div class="px-4 py-2 text-sm text-gray-500">Tidak ditemukan</div>
                @endforelse
            </div>
        </div>


    </div>
</div>
