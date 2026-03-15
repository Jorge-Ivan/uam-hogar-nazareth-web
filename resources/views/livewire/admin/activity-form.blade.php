<div>
    <div class="mb-6">
        <h2 class="text-xl font-medium text-gray-900">
            {{ $activityId ? 'Editar actividad' : 'Nueva actividad' }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ $activityId ? 'Modifica el contenido de la actividad.' : 'Completa los campos para crear una nueva actividad.' }}
        </p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="space-y-6">

            {{-- Título --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <input
                    id="title"
                    type="text"
                    wire:model.blur="title"
                    placeholder="Ej. Actividades recreativas de marzo"
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
                        /actividades/
                    </span>
                    <input
                        id="slug"
                        type="text"
                        wire:model.blur="slug"
                        placeholder="actividades-recreativas-marzo"
                        class="block w-full rounded-r-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('slug') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-400">Solo letras minúsculas, números y guiones. Se genera automáticamente desde el título.</p>
                @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Extracto --}}
            <div>
                <label for="excerpt" class="block text-sm font-medium text-gray-700">
                    Extracto
                    <span class="ml-1 text-xs font-normal text-gray-400">(opcional, máx. 500 caracteres)</span>
                </label>
                <textarea
                    id="excerpt"
                    wire:model.blur="excerpt"
                    rows="3"
                    placeholder="Breve descripción de la actividad para listados y redes sociales..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('excerpt') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                ></textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contenido --}}
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">
                    Contenido <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="content"
                    wire:model.blur="content"
                    rows="12"
                    placeholder="Describe la actividad con todos los detalles..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('content') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                ></textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Imagen destacada --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Imagen destacada
                    <span class="ml-1 text-xs font-normal text-gray-400">(JPG, PNG o WebP, máx. 5 MB)</span>
                </label>

                {{-- Current/preview image --}}
                @if ($imagePreviewUrl)
                    <div class="mt-2 flex items-start gap-4">
                        <img src="{{ $imagePreviewUrl }}" alt="Vista previa" class="h-32 w-48 rounded-lg object-cover shadow-sm">
                        <div>
                            <p class="text-xs text-gray-500">Nueva imagen seleccionada</p>
                            <button type="button" wire:click="removeImage"
                                class="mt-1 text-xs font-medium text-red-600 hover:text-red-700">
                                Quitar imagen
                            </button>
                        </div>
                    </div>
                @elseif ($existingImageUrl)
                    <div class="mt-2 flex items-start gap-4">
                        <img src="{{ $existingImageUrl }}" alt="Imagen actual" class="h-32 w-48 rounded-lg object-cover shadow-sm">
                        <p class="text-xs text-gray-500">Imagen actual. Selecciona una nueva para reemplazarla.</p>
                    </div>
                @endif

                {{-- Upload input --}}
                <div class="mt-3">
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
                        <span class="mt-1 text-xs text-gray-400">o arrastra y suelta aquí</span>
                        <input id="imageUpload" type="file" wire:model="imageUpload" accept="image/*" class="sr-only">
                    </label>
                </div>

                <div wire:loading wire:target="imageUpload" class="mt-2 text-xs text-nazareth-blue">
                    Cargando imagen...
                </div>

                @error('imageUpload')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estado --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Estado <span class="text-red-500">*</span>
                </label>
                <select
                    id="status"
                    wire:model="status"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('status') border-red-400 @enderror"
                >
                    <option value="draft">Borrador</option>
                    <option value="published">Publicado</option>
                    <option value="archived">Archivado</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
            <a
                href="{{ route('admin.activities.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                Cancelar
            </a>

            <button
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center rounded-lg border border-gray-400 bg-gray-100 px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 disabled:opacity-60">
                <span wire:loading.remove wire:target="save">Guardar borrador</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>

            <button
                wire:click="publish"
                wire:loading.attr="disabled"
                wire:target="publish"
                class="inline-flex items-center justify-center rounded-lg bg-nazareth-green px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-nazareth-green focus:ring-offset-2 disabled:opacity-60">
                <svg wire:loading.remove wire:target="publish" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span wire:loading.remove wire:target="publish">Publicar</span>
                <span wire:loading wire:target="publish">Publicando...</span>
            </button>
        </div>
    </div>
</div>
