<div class="mx-auto max-w-2xl">
    <form wire:submit="save" novalidate>
        <div class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">

            {{-- Nombre --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" wire:model="name"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-nazareth-blue focus:outline-none focus:ring-1 focus:ring-nazareth-blue @error('name') border-red-500 @enderror" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Correo electrónico --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" wire:model="email"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-nazareth-blue focus:outline-none focus:ring-1 focus:ring-nazareth-blue @error('email') border-red-500 @enderror" />
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Rol --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select id="role" wire:model="role"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-nazareth-blue focus:outline-none focus:ring-1 focus:ring-nazareth-blue @error('role') border-red-500 @enderror">
                    @foreach($roles as $roleOption)
                        <option value="{{ $roleOption->value }}">{{ $roleOption->label() }}</option>
                    @endforeach
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Contraseña
                    @if($userId !== null)
                        <span class="ml-1 text-xs text-gray-400">(dejar en blanco para no cambiar)</span>
                    @else
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                <input type="password" id="password" wire:model="password"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-nazareth-blue focus:outline-none focus:ring-1 focus:ring-nazareth-blue @error('password') border-red-500 @enderror" />
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div>
                <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700">
                    Confirmar contraseña
                </label>
                <input type="password" id="passwordConfirmation" wire:model="passwordConfirmation"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-nazareth-blue focus:outline-none focus:ring-1 focus:ring-nazareth-blue" />
            </div>
        </div>

        {{-- Acciones --}}
        <div class="mt-4 flex items-center justify-end gap-3">
            <a href="{{ route('admin.users.index') }}"
               class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                class="rounded-lg bg-nazareth-blue px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-nazareth-light">
                {{ $userId !== null ? 'Actualizar usuario' : 'Crear usuario' }}
            </button>
        </div>
    </form>
</div>
