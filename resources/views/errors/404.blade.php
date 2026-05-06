<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada | Hogar Nazareth</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-nazareth-paper font-sans antialiased min-h-screen flex flex-col items-center justify-center px-4">

    <div class="text-center max-w-md">
        <a href="{{ url('/') }}" class="inline-block mb-8">
            <img src="{{ asset('images/logo_fundacion.png') }}"
                 alt="Fundación Hogar del Anciano Nazareth"
                 class="h-16 w-auto mx-auto">
        </a>

        <p class="text-6xl font-semibold text-nazareth-blue mb-4">404</p>
        <h1 class="text-2xl font-medium text-nazareth-ink mb-3">Página no encontrada</h1>
        <p class="text-gray-500 text-base leading-relaxed mb-8">
            La página que buscas no existe o fue movida a otra dirección.
        </p>

        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 bg-nazareth-blue text-white px-6 py-3 rounded-[10px] text-sm font-medium hover:bg-nazareth-700 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
            Volver al inicio
        </a>
    </div>

</body>
</html>
