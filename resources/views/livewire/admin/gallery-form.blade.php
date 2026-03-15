<div>
    <div class="mb-6">
        <h2 class="text-xl font-medium text-gray-900">Nueva galería</h2>
        <p class="mt-1 text-sm text-gray-500">
            Completa los campos para crear una nueva galería. Podrás añadir imágenes después.
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
                <p class="mt-1 text-xs text-gray-400">Solo letras minúsculas, números y guiones. Se genera automáticamente desde el título.</p>
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

        {{-- Actions --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
            <a
                href="{{ route('admin.galleries.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                Cancelar
            </a>

            <button
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center rounded-lg bg-nazareth-blue px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2 disabled:opacity-60">
                <span wire:loading.remove wire:target="save">Crear galería</span>
                <span wire:loading wire:target="save">Creando...</span>
            </button>
        </div>
    </div>
</div>
