<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio en actualización | Fundación Centro de Bienestar del Anciano Nazareth</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-nazareth-blue font-sans antialiased min-h-screen flex flex-col items-center justify-center px-4">

    <div class="text-center max-w-lg">

        <div class="mb-10">
            <img src="{{ asset('images/logo_fundacion.png') }}"
                 alt="Fundación Centro de Bienestar del Anciano Nazareth"
                 class="h-20 w-auto mx-auto">
        </div>

        <span class="inline-block bg-nazareth-gold text-white text-xs font-medium tracking-widest uppercase px-4 py-1.5 rounded-full mb-8">
            Próximamente
        </span>

        <h1 class="text-3xl font-medium text-white mb-4 leading-snug">
            Estamos renovando nuestro sitio
        </h1>

        <p class="text-nazareth-200 text-base leading-relaxed mb-10 max-w-sm mx-auto">
            La Fundación está preparando una nueva experiencia digital. Vuelve pronto para conocer
            nuestras actividades, galería y formas de apoyarnos.
        </p>

        <div class="w-10 h-0.5 bg-nazareth-gold mx-auto mb-10"></div>

        <p class="text-nazareth-200 text-sm leading-relaxed">
            Mientras tanto, síguenos en
            <a href="https://web.facebook.com/hogardelanciano.nazareth"
               target="_blank"
               rel="noopener noreferrer"
               class="text-white underline underline-offset-2 hover:text-nazareth-400 transition-colors">
                Facebook
            </a>
            para estar al tanto de nuestras actividades.
        </p>

    </div>

</body>
</html>
