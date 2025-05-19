<div x-data="{ openModal: false }" class="bg-gray-200 min-h-full min-w-full flex justify-center items-center">
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
                    <p class="text-xs text-gray-600 truncate whitespace-nowrap text-ellipsis overflow-hidden">
                        {{ $selectedUser?->email }}</p>
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

        <div class="self-center p-4 mt-4 rounded-md flex flex-col w-[60%] justify-center">

            <button type="button" @click="openModal = true"
                class="mb-4 w-full py-1 text-white text-sm bg-emerald-600 rounded-md hover:bg-emerald-700 hover:cursor-pointer">Pilih
                Sampah</button>

            <div class="flex flex-col items-start border-1 border-gray-400 rounded-md h-[200px] overflow-y-auto mb-4">
                @foreach ($selectedSampah as $id => $data)
                    <div class="flex items-center gap-4 p-4 rounded w-full hover:bg-gray-50 transition">
                        <img src="{{ asset($data['gambar']) }}" alt="{{ $data['nama'] }}"
                            class="w-12 h-12 object-cover rounded">
                        <div class="flex-1">
                            <div class="uppercase text-sm text-gray-600">{{ $data['nama'] }}</div>
                            <input type="number" step="0.01" min="0"
                                wire:model.lazy="selectedSampah.{{ $id }}.berat"
                                class="border border-gray-400 text-sm px-2 py-0.5 rounded w-full focus:outline-none focus:ring-1 placeholder:text-xs focus:ring-emerald-400 transition"
                                placeholder="Masukkan berat dalam kg..">
                        </div>
                        <button type="button" wire:click="removeSampah({{ $id }})"
                            class="block w-8 h-8 bg-red-600 hover:bg-red-700 hover:cursor-pointer text-white font-bold rounded-md">X</button>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="button" wire:click="store"
            class="self-end py-2 px-4 bg-emerald-600 text-white hover:bg-emerald-700 hover:cursor-pointer rounded-xl">Buat
            Setoran</button>

    </div>





</div>
