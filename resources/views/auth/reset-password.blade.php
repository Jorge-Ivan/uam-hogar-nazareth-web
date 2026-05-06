<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nueva contraseña — Fundación Centro de Bienestar del Anciano Nazareth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-nazareth-gray font-sans antialiased">

    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg">

                {{-- Header --}}
                <div class="bg-nazareth-blue px-8 py-8 text-center">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-white/20">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-medium text-white">Nueva contraseña</h1>
                    <p class="mt-1 text-sm text-white/70">Elige una contraseña segura</p>
                </div>

                {{-- Body --}}
                <div class="px-8 py-8">

                    @if ($errors->any())
                        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" novalidate>
                        @csrf

                        {{-- Hidden token + email --}}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        {{-- Email (read-only display) --}}
                        <div class="mb-5">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Correo electrónico
                            </label>
                            <p class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600">
                                {{ $email }}
                            </p>
                        </div>

                        {{-- New password --}}
                        <div class="mb-5">
                            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">
                                Nueva contraseña <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autofocus
                                autocomplete="new-password"
                                class="block w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-nazareth-blue
                                    {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}"
                                placeholder="Mínimo 8 caracteres"
                            >
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm password --}}
                        <div class="mb-6">
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">
                                Confirmar contraseña <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-nazareth-blue"
                                placeholder="Repite la contraseña"
                            >
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-nazareth-blue px-4 py-3 text-sm font-medium text-white shadow-sm transition hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2"
                        >
                            Restablecer contraseña
                        </button>
                    </form>
                </div>
            </div>

            <p class="mt-6 text-center text-xs text-gray-500">
                Fundación Centro de Bienestar del Anciano Nazareth &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

</body>
</html>
