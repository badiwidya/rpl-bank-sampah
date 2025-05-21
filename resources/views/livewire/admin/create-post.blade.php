<div class="bg-gradient-to-b from-emerald-50 py-8 to-emerald-200 min-h-full min-w-full flex justify-center items-center">


    <div
        class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-8 rounded-xl min-h-[90%] shadow-xl w-full max-w-[80%]">
        <h1 class="font-semibold text-xl mb-4">Buat Postingan Baru</h1>
        <form wire:submit="save" class="flex flex-col">
            <div class="mb-4">
                <label>Judul</label>
                <input type="text" wire:model="postTitle" placeholder="Masukkan judul postingan..."
                    class="w-full px-4 py-2 placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('postTitle') border-red-500 focus:ring-red-500 @enderror" />
                @error('postTitle')
                    <div class="text-sm text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label>Kategori</label>
                <div x-data="{ selected: @entangle('categorySelected') }" class="flex gap-2 flex-wrap">
                    @foreach ($categories as $category)
                        <button type="button" @click="selected = '{{ $category->id }}'"
                            :class="selected === '{{ $category->id }}'
                                ?
                                'bg-emerald-300 text-emerald-700 border-emerald-400' :
                                'bg-gray-200 text-gray-600 border-gray-400 hover:bg-gray-300'"
                            class="py-1 px-3 rounded-full text-sm border transition-all duration-300 hover:cursor-pointer">
                            {{ $category->nama }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="mb-4" wire:ignore>
                <label>Konten</label>
                <input id="x" x-ref="input" type="hidden" wire:model="content">
                <trix-editor input="x" x-ref="editor"
                    class="h-64 focus:ring-2 overflow-y-auto focus:outline-none focus:ring-emerald-400 transition duration-300 trix-editor trix-content"
                    @trix-blur="$wire.set('content', $refs.input.value)"
                    @trix-attachment-add="handleImageUpload($event)"></trix-editor>
            </div>

            <button wire:click="save" type="button"
                class="bg-emerald-600 py-2 rounded-lg text-white hover:bg-emerald-700 hover:cursor-pointer">Buat
                Postingan</button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('trix-file-accept', function(event) {
                if (!event.file.type.startsWith('image/')) {
                    event.preventDefault();
                    Toaster.error('Hanya file gambar yang diperbolehkan!');
                }
            });

            function handleImageUpload(event) {
                const attachment = event.attachment;

                if (attachment.file) {
                    attachment.setAttributes({
                        previewable: true,
                        url: URL.createObjectURL(attachment.file)
                    });

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const base64Data = e.target.result;

                        @this.call('uploadImage', base64Data)
                            .then(response => {
                                if (response.error) {
                                    console.error(response.error);
                                    attachment.remove();
                                    Toaster.error('Gagal mengunggah gambar: ' + response.error);
                                } else {
                                    attachment.setAttributes({
                                        url: response.url,
                                        href: response.url
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                attachment.remove();
                                Toaster.error('Terjadi kesalahan saat mengunggah gambar.');
                            });
                    };
                    reader.readAsDataURL(attachment.file);
                }
            }
        </script>
    @endpush
</div>
