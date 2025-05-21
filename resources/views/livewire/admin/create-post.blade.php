<div class="bg-gradient-to-b from-emerald-50 to-emerald-200 min-h-full min-w-full flex justify-center items-center">

    <div class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-[80%]">
        <h1 class="font-semibold text-xl mb-4">Buat Postingan Baru</h1>

        <label>Judul</label>
        <input type="text" wire:model.blur="postTitle" placeholder="Masukkan judul postingan..."
            class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('postTitle') border-red-500 focus:ring-red-500 @enderror" />
        @error('postTitle')
            <div class="text-sm text-red-400">{{ $message }}</div>
        @enderror

 
    </div>

</div>
