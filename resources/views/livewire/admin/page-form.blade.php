<div>
    <div class="mb-6">
        <h2 class="text-xl font-medium text-gray-900">
            {{ $pageId ? 'Editar página' : 'Nueva página' }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ $pageId ? 'Modifica el contenido de la página.' : 'Completa los campos para crear una nueva página institucional.' }}
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
                    placeholder="Ej. Quiénes somos"
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
                    <span class="text-sm text-gray-400">/paginas/</span>
                    <span class="text-sm text-gray-700">{{ $slug ?: '—' }}</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">Se genera automáticamente desde el título.</p>
            </div>

            {{-- Contenido (editor enriquecido) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Contenido <span class="text-red-500">*</span>
                </label>

                {{-- wire:ignore: Quill es dueño de este DOM, Livewire no lo morfea --}}
                <div wire:ignore class="mt-1 rounded-lg border border-gray-200 shadow-sm">
                    <div
                        id="quill-editor"
                        data-content="{{ $content }}"
                    ></div>
                </div>

                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                {{-- Botón para abrir galería de medios --}}
                <div class="mt-2">
                    <button type="button"
                        wire:click="loadMediaLibrary"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-3 py-1.5
                               text-xs font-medium text-gray-600 transition-colors hover:bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-gray-300">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0
                                   L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Insertar imagen existente
                    </button>
                </div>

                {{-- Panel galería de medios: FUERA de wire:ignore, Livewire lo renderiza directamente --}}
                @if ($showMediaBrowser)
                    <div class="mt-3 rounded-xl border border-gray-200 bg-white p-4 shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">Seleccionar imagen existente</h3>
                            <button type="button" wire:click="$set('showMediaBrowser', false)"
                                class="text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        @if (count($mediaItems) === 0)
                            <p class="py-8 text-center text-sm text-gray-400">No hay imágenes subidas aún.</p>
                        @else
                            <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-5">
                                @foreach ($mediaItems as $item)
                                    <button
                                        type="button"
                                        onclick="window.insertFromLibrary('{{ $item['url'] }}', '{{ addslashes($item['alt']) }}')"
                                        class="group relative aspect-square overflow-hidden rounded-lg border-2 border-transparent
                                               hover:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue">
                                        <img src="{{ $item['url'] }}" alt="{{ $item['alt'] }}"
                                             class="h-full w-full object-cover transition group-hover:opacity-90">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
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

        {{-- ── Navegación ─────────────────────────────────────────────── --}}
        <div class="mt-6 border-t border-gray-200 pt-6">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                Navegación
            </h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                {{-- Página superior (parent) --}}
                <div>
                    <label for="parentId" class="block text-sm font-medium text-gray-700">
                        Página superior
                    </label>
                    <select
                        id="parentId"
                        wire:model="parentId"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                        <option value="">Ninguna (página principal)</option>
                        @foreach ($parentPageOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->title }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-400">
                        Si selecciona una página, esta aparecerá como submenú de ella.
                    </p>
                    @error('parentId')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Orden en menú --}}
                <div>
                    <label for="menuOrder" class="block text-sm font-medium text-gray-700">
                        Orden en menú
                    </label>
                    <input
                        id="menuOrder"
                        type="number"
                        min="0"
                        max="999"
                        wire:model="menuOrder"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('menuOrder') border-red-400 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-400">
                        Número menor aparece primero. Use 0, 10, 20… para facilitar reordenar.
                    </p>
                    @error('menuOrder')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Visibilidad en menús --}}
            <div class="mt-4 flex flex-wrap gap-6">
                <label class="flex cursor-pointer items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="showInHeader"
                        class="h-4 w-4 rounded border-gray-300 text-nazareth-blue focus:ring-nazareth-blue"
                    >
                    <span class="text-sm text-gray-700">Mostrar en menú principal</span>
                </label>

                <label class="flex cursor-pointer items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="showInFooter"
                        class="h-4 w-4 rounded border-gray-300 text-nazareth-blue focus:ring-nazareth-blue"
                    >
                    <span class="text-sm text-gray-700">Mostrar en pie de página</span>
                </label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
            <a
                href="{{ route('admin.pages.index') }}"
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
