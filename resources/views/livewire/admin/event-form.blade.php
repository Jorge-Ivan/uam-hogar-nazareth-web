<div>
    <div class="mb-6">
        <h2 class="text-xl font-medium text-gray-900">
            {{ $eventId ? 'Editar evento' : 'Nuevo evento' }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ $eventId ? 'Modifica la información del evento.' : 'Completa los campos para crear un nuevo evento.' }}
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
                    placeholder="Ej. Celebración del Día del Adulto Mayor"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('title') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug (solo lectura) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">URL</label>
                <div class="mt-1 flex items-center gap-1.5 rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5">
                    <span class="text-sm text-gray-400">/eventos/</span>
                    <span class="text-sm text-gray-700">{{ $slug ?: '—' }}</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">Se genera automáticamente desde el título.</p>
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Descripción
                    <span class="ml-1 text-xs font-normal text-gray-400">(opcional)</span>
                </label>
                <textarea
                    id="description"
                    wire:model.blur="description"
                    rows="4"
                    placeholder="Describe el evento, actividades planeadas, información relevante..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('description') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                ></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fechas --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                {{-- Fecha de inicio --}}
                <div>
                    <label for="startDate" class="block text-sm font-medium text-gray-700">
                        Fecha de inicio <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="startDate"
                        type="date"
                        wire:model.blur="startDate"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('startDate') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                    >
                    @error('startDate')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de fin --}}
                <div>
                    <label for="endDate" class="block text-sm font-medium text-gray-700">
                        Fecha de fin
                        <span class="ml-1 text-xs font-normal text-gray-400">(opcional)</span>
                    </label>
                    <input
                        id="endDate"
                        type="date"
                        wire:model.blur="endDate"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('endDate') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                    >
                    @error('endDate')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Ubicación --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">
                    Ubicación
                    <span class="ml-1 text-xs font-normal text-gray-400">(opcional)</span>
                </label>
                <input
                    id="location"
                    type="text"
                    wire:model.blur="location"
                    placeholder="Ej. Salón principal, Fundación Centro de Bienestar del Anciano Nazareth"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('location') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                >
                @error('location')
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

        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
            <a
                href="{{ route('admin.events.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                Cancelar
            </a>

            <button
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center rounded-lg bg-nazareth-blue px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2 disabled:opacity-60">
                <span wire:loading.remove wire:target="save">Guardar evento</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>
    </div>
</div>
