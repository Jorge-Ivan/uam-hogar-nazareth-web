<div>
    {{-- Header row --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-medium text-gray-900">Actividades</h2>

        <a href="{{ route('admin.activities.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-nazareth-blue px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva actividad
        </a>
    </div>

    {{-- Filters --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row">
        <div class="flex-1">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar por título..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
            >
        </div>

        <div>
            <select
                wire:model.live="statusFilter"
                class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
            >
                <option value="">Todos los estados</option>
                <option value="draft">Borrador</option>
                <option value="published">Publicado</option>
                <option value="archived">Archivado</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        @if ($activities->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 2v6h6"/>
                </svg>
                <p class="mt-3 text-sm text-gray-500">No se encontraron actividades.</p>
                <a href="{{ route('admin.activities.create') }}"
                   class="mt-3 text-sm font-medium text-nazareth-blue hover:text-nazareth-light">
                    Crear la primera actividad
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
                            Imagen
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Publicado
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($activities as $activity)
                        <tr wire:key="{{ $activity->id }}" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $activity->title }}</div>
                                <div class="text-xs text-gray-400">{{ $activity->slug }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($activity->featuredImage)
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($activity->featuredImage->file_path) }}"
                                        alt="{{ $activity->featuredImage->alt_text ?? $activity->title }}"
                                        class="h-12 w-12 rounded object-cover"
                                    >
                                @else
                                    <span class="text-xs text-gray-400">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($activity->status->value === 'published')
                                    <span class="inline-flex items-center rounded-full bg-nazareth-green/10 px-2.5 py-0.5 text-xs font-medium text-nazareth-green">
                                        Publicado
                                    </span>
                                @elseif ($activity->status->value === 'archived')
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                        Archivado
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">
                                        Borrador
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $activity->published_at?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.activities.edit', $activity) }}"
                                       class="inline-flex items-center rounded-lg border border-nazareth-blue/30 px-3 py-1.5 text-xs font-medium text-nazareth-blue transition-colors hover:bg-nazareth-blue hover:text-white focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-1">
                                        Editar
                                    </a>

                                    @if ($activity->status->value !== 'published')
                                        <button
                                            wire:click="publishActivity({{ $activity->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="publishActivity({{ $activity->id }})"
                                            class="inline-flex items-center rounded-lg border border-nazareth-green/30 px-3 py-1.5 text-xs font-medium text-nazareth-green transition-colors hover:bg-nazareth-green hover:text-white focus:outline-none focus:ring-2 focus:ring-nazareth-green focus:ring-offset-1 disabled:opacity-60">
                                            Publicar
                                        </button>
                                    @endif

                                    <button
                                        wire:click="confirmDelete({{ $activity->id }})"
                                        class="inline-flex items-center rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition-colors hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($activities->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $activities->links() }}
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
                    <h3 class="text-base font-medium text-gray-900">Eliminar actividad</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Esta acción no se puede deshacer. La actividad será eliminada permanentemente.
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
                    wire:click="deletePage"
                    wire:loading.attr="disabled"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-60">
                    <span wire:loading.remove wire:target="deletePage">Eliminar</span>
                    <span wire:loading wire:target="deletePage">Eliminando...</span>
                </button>
            </div>
        </div>
    </div>
</div>
