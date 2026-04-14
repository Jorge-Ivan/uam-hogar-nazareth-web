<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recuperar contraseña — Hogar Nazareth</title>
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
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-medium text-white">Recuperar contraseña</h1>
                    <p class="mt-1 text-sm text-white/70">Te enviaremos un enlace por correo</p>
                </div>

                {{-- Body --}}
                <div class="px-8 py-8">

                    {{-- Success message --}}
                    @if (session('status'))
                        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="mb-6 text-sm text-gray-600">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}" novalidate>
                        @csrf

                        <div class="mb-6">
                            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">
                                Correo electrónico <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                class="block w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-nazareth-blue
                                    {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}"
                                placeholder="correo@ejemplo.com"
                            >
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-nazareth-blue px-4 py-3 text-sm font-medium text-white shadow-sm transition hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2"
                        >
                            Enviar enlace de recuperación
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-nazareth-blue hover:text-nazareth-light">
                            ← Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>

            <p class="mt-6 text-center text-xs text-gray-500">
                Fundación Hogar del Anciano Nazareth &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

</body>
</html>
