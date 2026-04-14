<div>
    {{-- Header row --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-medium text-gray-900">Documentos de transparencia</h2>

        <a href="{{ route('admin.documents.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-nazareth-blue px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Subir documento
        </a>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-nazareth-green/10 px-4 py-3 text-sm font-medium text-nazareth-green">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row">
        <div>
            <select
                wire:model.live="categoryFilter"
                class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
            >
                <option value="">Todas las categorías</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select
                wire:model.live="yearFilter"
                class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
            >
                <option value="">Todos los años</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        @if ($documents->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-3 text-sm text-gray-500">No se encontraron documentos.</p>
                <a href="{{ route('admin.documents.create') }}"
                   class="mt-3 text-sm font-medium text-nazareth-blue hover:text-nazareth-light">
                    Subir el primer documento
                </a>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Título
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Categoría
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Año
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Archivo
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($documents as $document)
                        <tr wire:key="{{ $document->id }}" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $document->title }}</div>
                                @if ($document->description)
                                    <div class="mt-0.5 text-xs text-gray-400 line-clamp-1">{{ $document->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $document->category?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $document->year ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($document->media)
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($document->media->file_path) }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1 text-sm font-medium text-nazareth-blue hover:text-nazareth-light">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Descargar
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">Sin archivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        wire:click="confirmDelete({{ $document->id }})"
                                        class="inline-flex items-center rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition-colors hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($documents->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $documents->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- Delete confirmation modal --}}
    <div
        x-data
        x-show="$wire.deleteId !== null"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        style="display: none;"
    >
        <div
            x-show="$wire.deleteId !== null"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl"
            @click.outside="$wire.cancelDelete()"
        >
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-medium text-gray-900">Eliminar documento</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Esta acción no se puede deshacer. El documento será eliminado permanentemente.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    wire:click="cancelDelete"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancelar
                </button>
                <button
                    wire:click="deleteDocument"
                    wire:loading.attr="disabled"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-60">
                    <span wire:loading.remove wire:target="deleteDocument">Eliminar</span>
                    <span wire:loading wire:target="deleteDocument">Eliminando...</span>
                </button>
            </div>
        </div>
    </div>
</div>
