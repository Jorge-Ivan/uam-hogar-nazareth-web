<div>
    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-medium text-gray-900">{{ $gallery->title }}</h2>
            <p class="mt-1 text-sm text-gray-500">
                Edita los detalles de la galería y gestiona sus imágenes.
            </p>
        </div>
        <a href="{{ route('admin.galleries.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-nazareth-blue hover:text-nazareth-light">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a galerías
        </a>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-nazareth-green/10 px-4 py-3 text-sm font-medium text-nazareth-green">
            {{ session('success') }}
        </div>
    @endif

    {{-- Gallery details form --}}
    <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-base font-medium text-gray-900">Detalles de la galería</h3>

        <div class="space-y-5">

            {{-- Título --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <input
                    id="title"
                    type="text"
                    wire:model.blur="title"
                    placeholder="Ej. Actividades de marzo 2024"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('title') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">
                    URL (slug) <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                        /galerias/
                    </span>
                    <input
                        id="slug"
                        type="text"
                        wire:model.blur="slug"
                        placeholder="actividades-marzo-2024"
                        class="block w-full rounded-r-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('slug') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-400">Solo letras minúsculas, números y guiones.</p>
                @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Descripción
                    <span class="ml-1 text-xs font-normal text-gray-400">(opcional, máx. 500 caracteres)</span>
                </label>
                <textarea
                    id="description"
                    wire:model.blur="description"
                    rows="3"
                    placeholder="Breve descripción de la galería..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('description') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                ></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-6 flex justify-end border-t border-gray-100 pt-5">
            <button
                wire:click="saveDetails"
                wire:loading.attr="disabled"
                wire:target="saveDetails"
                class="inline-flex items-center justify-center rounded-lg bg-nazareth-blue px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2 disabled:opacity-60">
                <span wire:loading.remove wire:target="saveDetails">Guardar cambios</span>
                <span wire:loading wire:target="saveDetails">Guardando...</span>
            </button>
        </div>
    </div>

    {{-- Images section --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-base font-medium text-gray-900">
            Imágenes ({{ count($gallery->images) }})
        </h3>

        @if ($gallery->images->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-200 py-12 text-center">
                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="mt-3 text-sm text-gray-500">Esta galería no tiene imágenes aún.</p>
                <p class="mt-1 text-xs text-gray-400">Usa el formulario de abajo para subir la primera imagen.</p>
            </div>
        @else
            <div
                id="gallery-grid"
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
            >
                @foreach ($gallery->images as $image)
                    <div
                        wire:key="image-{{ $image->id }}"
                        data-id="{{ $image->id }}"
                        class="group relative overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm"
                    >
                        {{-- Drag handle --}}
                        <div data-drag-handle
                             class="absolute left-2 top-2 z-10 flex h-7 w-7 cursor-move items-center justify-center rounded-md bg-white/80 shadow-sm"
                             title="Arrastra para reordenar">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 8h16M4 16h16"/>
                            </svg>
                        </div>

                        {{-- Thumbnail --}}
                        <div class="aspect-video overflow-hidden bg-gray-100">
                            @if ($image->media)
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->media->file_path) }}"
                                    alt="{{ $image->media->alt_text ?? $image->caption ?? 'Imagen de galería' }}"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                >
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Caption and actions --}}
                        <div class="p-3">
                            <p class="text-xs text-gray-500">
                                {{ $image->caption ?? 'Sin descripción' }}
                            </p>
                            <div class="mt-2 flex justify-end">
                                <button
                                    wire:click="removeImage({{ $image->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="removeImage({{ $image->id }})"
                                    wire:confirm="¿Eliminar esta imagen de la galería?"
                                    class="inline-flex items-center rounded-md border border-red-200 px-2.5 py-1 text-xs font-medium text-red-600 transition-colors hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 disabled:opacity-60">
                                    <span wire:loading.remove wire:target="removeImage({{ $image->id }})">Eliminar</span>
                                    <span wire:loading wire:target="removeImage({{ $image->id }})">...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="mt-3 text-xs text-gray-400">
                Arrastra las imágenes para cambiar su orden.
            </p>
        @endif

        {{-- Upload form --}}
        <div class="mt-8 border-t border-gray-100 pt-6">
            <h4 class="mb-4 text-sm font-medium text-gray-700">Subir nueva imagen</h4>

            <div class="space-y-4">

                {{-- Caption input --}}
                <div>
                    <label for="newCaption" class="block text-sm font-medium text-gray-700">
                        Descripción de la imagen
                        <span class="ml-1 text-xs font-normal text-gray-400">(opcional)</span>
                    </label>
                    <input
                        id="newCaption"
                        type="text"
                        wire:model.live="newCaption"
                        placeholder="Ej. Actividad de fisioterapia grupal"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                {{-- Image preview --}}
                @if ($imagePreviewUrl)
                    <div class="flex items-start gap-4">
                        <img src="{{ $imagePreviewUrl }}" alt="Vista previa" class="h-32 w-48 rounded-lg object-cover shadow-sm">
                        <div>
                            <p class="text-xs text-gray-500">Imagen seleccionada</p>
                            <button
                                type="button"
                                wire:click="$set('imageUpload', null); $set('imagePreviewUrl', null)"
                                class="mt-1 text-xs font-medium text-red-600 hover:text-red-700">
                                Quitar
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Upload zone --}}
                <div>
                    <label for="imageUpload"
                        class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-6 text-center transition-colors hover:border-nazareth-blue hover:bg-nazareth-blue/5
                               @error('imageUpload') border-red-400 @enderror">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="mt-2 text-sm text-gray-600">
                            Haz clic para seleccionar una imagen
                        </span>
                        <span class="mt-1 text-xs text-gray-400">JPG, PNG o WebP, máx. 10 MB</span>
                        <input
                            id="imageUpload"
                            type="file"
                            wire:model="imageUpload"
                            accept="image/jpeg,image/png,image/webp"
                            class="sr-only"
                        >
                    </label>
                </div>

                <div wire:loading wire:target="imageUpload" class="text-xs text-nazareth-blue">
                    Cargando imagen...
                </div>

                @error('imageUpload')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button
                        wire:click="uploadImage"
                        wire:loading.attr="disabled"
                        wire:target="uploadImage"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-nazareth-blue px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2 disabled:opacity-60">
                        <svg wire:loading.remove wire:target="uploadImage" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <span wire:loading.remove wire:target="uploadImage">Subir imagen</span>
                        <span wire:loading wire:target="uploadImage">Subiendo...</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
