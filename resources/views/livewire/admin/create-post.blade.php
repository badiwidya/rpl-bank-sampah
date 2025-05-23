<div class="bg-gradient-to-b from-emerald-50 py-4 sm:py-6 md:py-8 to-emerald-200 min-h-full min-w-full flex justify-center items-center px-3 sm:px-4">


    <div
        class="bg-white bg-opacity-90 flex flex-col backdrop-blur-md p-4 sm:p-6 md:p-8 rounded-lg sm:rounded-xl min-h-[90%] shadow-xl w-full max-w-full sm:max-w-[90%] md:max-w-[80%]">
        <h1 class="font-semibold text-lg sm:text-xl mb-3 sm:mb-4">Buat Postingan Baru</h1>

        <div class="mb-3 sm:mb-4">
            <label class="text-sm sm:text-base">Judul</label>
            <input type="text" wire:model="postTitle" placeholder="Masukkan judul postingan..."
                class="w-full px-3 sm:px-4 py-1.5 sm:py-2 text-sm placeholder:text-xs sm:placeholder:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-400 transition duration-300 @error('postTitle') border-red-500 focus:ring-red-500 @enderror" />
            @error('postTitle')
                <div class="text-xs sm:text-sm text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 sm:mb-4">
            <label class="text-sm sm:text-base">Kategori</label>
            <div x-data="{ selected: @entangle('categorySelected') }" class="flex gap-1.5 sm:gap-2 flex-wrap">
                @foreach ($categories as $category)
                    <button type="button" @click="selected = '{{ $category->id }}'"
                        :class="selected === '{{ $category->id }}'
                            ?
                            'bg-emerald-300 text-emerald-700 border-emerald-400' :
                            'bg-gray-200 text-gray-600 border-gray-400 hover:bg-gray-300'"
                        class="py-0.5 sm:py-1 px-2 sm:px-3 rounded-full text-xs sm:text-sm border transition-all duration-300 hover:cursor-pointer">
                        {{ $category->nama }}
                    </button>
                @endforeach
            </div>
            @error('categorySelected')
                <div class="text-xs sm:text-sm text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <div wire:ignore class="mb-3 sm:mb-5">
            <label class="text-sm sm:text-base">Konten</label>
            <input id="x" x-ref="input" type="hidden" wire:model="content">
            <div class="trix-container">
                <trix-editor input="x" x-ref="editor"
                    class="h-48 sm:h-56 md:h-64 focus:ring-2 overflow-y-auto focus:outline-none focus:ring-emerald-400 transition duration-300 text-sm sm:text-base @error('content') border-red-500 ring-red-500 @enderror trix-editor trix-content"
                    @trix-blur="$wire.set('content', $refs.input.value)" @trix-attachment-add="handleImageUpload($event)"
                    @trix-attachment-remove="handleImageDelete($event)"></trix-editor>
            </div>
        </div>
        @error('content')
            <div class="text-xs sm:text-sm text-red-400">{{ $message }}</div>
        @enderror

        <button wire:click="save" type="button"
            class="mt-4 bg-emerald-600 py-1.5 sm:py-2 px-3 sm:px-4 rounded-lg text-white text-sm sm:text-base font-medium hover:bg-emerald-700 transition-colors duration-300 hover:cursor-pointer">Buat
            Postingan</button>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('trix-file-accept', function(event) {
                if (!event.file.type.startsWith('image/')) {
                    event.preventDefault();
                    Toaster.error('Hanya file gambar yang diperbolehkan!');
                }
            });

            document.addEventListener('trix-attachment-add', function(event) {
                const attachment = event.attachment;
                if (attachment) {
                    attachment.setAttributes({
                        caption: ''
                    });
                }
            });

            document.addEventListener('trix-initialize', function() {
                const editor = document.querySelector('trix-editor');
                if (editor && editor.editor) {
                    const attachments = editor.editor.getAttachments();
                    if (attachments && attachments.length > 0) {
                        attachments.forEach(attachment => {
                            attachment.setAttributes({
                                caption: ''
                            });
                        });
                    }
                }
            });

            function handleImageUpload(event) {
                const attachment = event.attachment;

                if (attachment.file) {
                    attachment.setAttributes({
                        previewable: true,
                        url: URL.createObjectURL(attachment.file),
                        caption: ''
                    });

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const base64Data = e.target.result;

                        @this.call('uploadImage', base64Data)
                            .then(response => {
                                if (response.error) {
                                    attachment.remove();
                                    Toaster.error('Gagal mengunggah gambar: ' + response.error);
                                } else {
                                    attachment.setAttributes({
                                        url: response.url,
                                        href: response.url,
                                        caption: ''
                                    });
                                }
                            })
                            .catch(error => {
                                attachment.remove();
                                Toaster.error('Terjadi kesalahan saat mengunggah gambar.');
                            });
                    };
                    reader.readAsDataURL(attachment.file);
                }
            }

            function handleImageDelete(event) {
                const attachment = event.attachment;

                if (attachment && attachment.getURL) {
                    const imageUrl = attachment.getURL();

                    if (imageUrl) {
                        @this.call('deleteImage', imageUrl)
                            .then(response => {
                                if (response.error) {
                                    Toaster.error('Gagal menghapus gambar: ' + response.error);
                                }
                            })
                            .catch(error => {
                                Toaster.error('Terjadi kesalahan saat menghapus gambar.');
                            });
                    }
                }
            }
        </script>
    @endpush
</div>
