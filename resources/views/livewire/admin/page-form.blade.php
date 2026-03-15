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

            {{-- Contenido --}}
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">
                    Contenido <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="content"
                    wire:model.blur="content"
                    rows="12"
                    placeholder="Escribe aquí el contenido de la página..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('content') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                ></textarea>
                @error('content')
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
