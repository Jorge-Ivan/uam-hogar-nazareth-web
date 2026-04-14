<div>
    <div class="mb-6">
        <h2 class="text-xl font-medium text-gray-900">Subir documento</h2>
        <p class="mt-1 text-sm text-gray-500">
            Completa los campos y adjunta el archivo PDF para registrar un nuevo documento de transparencia.
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
                    placeholder="Ej. Registro DIAN 2024"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('title') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Descripción
                    <span class="ml-1 text-xs font-normal text-gray-400">(opcional, máx. 1000 caracteres)</span>
                </label>
                <textarea
                    id="description"
                    wire:model.blur="description"
                    rows="3"
                    placeholder="Breve descripción del documento..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('description') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                ></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Categoría --}}
            <div>
                <label for="categoryId" class="block text-sm font-medium text-gray-700">
                    Categoría <span class="text-red-500">*</span>
                </label>
                <select
                    id="categoryId"
                    wire:model="categoryId"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('categoryId') border-red-400 @enderror"
                >
                    <option value="">Seleccionar categoría...</option>
                    @forelse ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @empty
                        <option disabled>Sin categorías disponibles</option>
                    @endforelse
                </select>
                @if ($categories->isEmpty())
                    <p class="mt-1 text-xs text-gray-400">Si no hay opciones, contacte al administrador para crear las categorías.</p>
                @endif
                @error('categoryId')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Año --}}
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">
                    Año <span class="text-red-500">*</span>
                </label>
                <input
                    id="year"
                    type="text"
                    wire:model.blur="year"
                    placeholder="Ej. 2024"
                    maxlength="4"
                    inputmode="numeric"
                    class="mt-1 block w-32 rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm placeholder:text-gray-400
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('year') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                >
                <p class="mt-1 text-xs text-gray-400">4 dígitos, entre 2000 y {{ date('Y') + 1 }}.</p>
                @error('year')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Archivo PDF --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Archivo PDF <span class="text-red-500">*</span>
                    <span class="ml-1 text-xs font-normal text-gray-400">(máx. 20 MB)</span>
                </label>

                {{-- Filename display after selection --}}
                @if ($fileName)
                    <div class="mt-2 flex items-center gap-3 rounded-lg border border-nazareth-green/30 bg-nazareth-green/5 px-4 py-3">
                        <svg class="h-5 w-5 shrink-0 text-nazareth-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm text-gray-700 truncate">{{ $fileName }}</span>
                    </div>
                @endif

                {{-- Upload zone --}}
                <div class="mt-3">
                    <label for="fileUpload"
                        class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-6 text-center transition-colors hover:border-nazareth-blue hover:bg-nazareth-blue/5
                               @error('fileUpload') border-red-400 @enderror">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="mt-2 text-sm text-gray-600">
                            Haz clic para seleccionar un PDF
                        </span>
                        <span class="mt-1 text-xs text-gray-400">o arrastra y suelta aquí · Solo archivos .pdf · máx. 20 MB</span>
                        <input id="fileUpload" type="file" wire:model="fileUpload" accept=".pdf" class="sr-only">
                    </label>
                </div>

                <div wire:loading wire:target="fileUpload" class="mt-2 text-xs text-nazareth-blue">
                    Cargando archivo...
                </div>

                @error('fileUpload')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
            <a
                href="{{ route('admin.documents.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                Cancelar
            </a>

            <button
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center rounded-lg bg-nazareth-blue px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2 disabled:opacity-60">
                <svg wire:loading.remove wire:target="save" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span wire:loading.remove wire:target="save">Subir documento</span>
                <span wire:loading wire:target="save">Subiendo...</span>
            </button>
        </div>
    </div>
</div>
