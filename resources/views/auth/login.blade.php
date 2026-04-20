<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar sesión — Hogar Nazareth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(config('services.recaptcha.site_key'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" defer></script>
    @endif
</head>
<body class="min-h-screen bg-nazareth-gray font-sans antialiased">

    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            {{-- Card --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-lg">

                {{-- Header --}}
                <div class="bg-nazareth-blue px-8 py-8 text-center">
                    <img src="/images/logo.png"
                         alt="Fundación Hogar del Anciano Nazareth"
                         class="mx-auto mb-4 h-20 w-auto">
                    <h1 class="text-xl font-medium text-white">Iniciar sesión</h1>
                    <p class="mt-1 text-sm text-white/70">Panel de administración</p>
                </div>

                {{-- Form --}}
                <div class="px-8 py-8">

                    {{-- General error --}}
                    @if ($errors->any())
                        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('login') }}"
                        x-data
                        x-on:submit.prevent="
                            if (!document.querySelector('[name=recaptcha_token]').value) {
                                grecaptcha.ready(function() {
                                    grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'login'}).then(function(token) {
                                        document.querySelector('[name=recaptcha_token]').value = token;
                                        $el.submit();
                                    });
                                });
                            } else {
                                $el.submit();
                            }
                        "
                        novalidate>
                        @csrf
                        <input type="hidden" name="recaptcha_token" value="">

                        {{-- Email --}}
                        <div class="mb-5">
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

                        {{-- Password --}}
                        <div class="mb-5">
                            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="block w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-nazareth-blue
                                    {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}"
                                placeholder="••••••••"
                            >
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember me + forgot password --}}
                        <div class="mb-6 flex items-center justify-between gap-2.5">
                            <div class="flex items-center gap-2.5">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    class="h-4 w-4 rounded border-gray-300 text-nazareth-blue focus:ring-nazareth-blue"
                                >
                                <label for="remember" class="text-sm text-gray-600">
                                    Recordarme
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}"
                               class="shrink-0 text-sm font-medium text-nazareth-blue hover:text-nazareth-light">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-nazareth-blue px-4 py-3 text-sm font-medium text-white shadow-sm transition hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2"
                        >
                            Entrar
                        </button>
                    </form>
                </div>
            </div>

            <p class="mt-6 text-center text-xs text-gray-500">
                Fundación Hogar del Anciano Nazareth &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

</body>
</html>
