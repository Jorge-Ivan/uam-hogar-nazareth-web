<div>
    <div class="mb-4 flex items-center justify-between">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Buscar por nombre o correo…"
            class="w-full max-w-xs rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-nazareth-blue focus:outline-none focus:ring-1 focus:ring-nazareth-blue"
        />
        <a href="{{ route('admin.users.create') }}"
           class="ml-4 inline-flex items-center gap-2 rounded-lg bg-nazareth-blue px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-nazareth-light">
            + Nuevo usuario
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Nombre</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Correo</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Rol</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Creado</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium text-gray-900">
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="ml-1 text-xs text-gray-400">(tú)</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-3">
                            @if($user->role === \App\Enums\UserRole::Admin)
                                <span class="inline-flex items-center rounded-full bg-nazareth-blue/10 px-2.5 py-0.5 text-xs font-medium text-nazareth-blue">
                                    {{ $user->role->label() }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">
                                    {{ $user->role->label() }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="mr-2 text-nazareth-blue hover:underline">Editar</a>
                            @if($user->id !== auth()->id())
                                <button
                                    wire:click="deleteUser({{ $user->id }})"
                                    wire:confirm="¿Estás seguro de que deseas eliminar este usuario?"
                                    class="text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                            No se encontraron usuarios.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
