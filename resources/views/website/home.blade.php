@extends('layouts.public')

@section('meta_title', 'Inicio')
@section('meta_description', 'Fundación dedicada al cuidado y atención de adultos mayores con amor y dignidad.')

@section('content')

{{-- ══════════════════════════════════════════
     HERO
     ══════════════════════════════════════════ --}}
<section class="relative min-h-[600px] flex items-center bg-gradient-to-r from-nazareth-blue to-nazareth-light overflow-hidden">
    {{-- Overlay decorativo --}}
    <div class="absolute inset-0 bg-nazareth-blue/60"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="max-w-2xl">
            {{-- Insignia --}}
            <span class="inline-block bg-nazareth-gold text-white text-xs px-3 py-1 rounded-full uppercase tracking-wide font-medium mb-6">
                Fundación de adultos mayores
            </span>

            {{-- Título principal --}}
            <h1 class="text-4xl md:text-5xl font-semibold text-white leading-tight mb-6">
                Cuidando con amor y dignidad
            </h1>

            {{-- Subtítulo --}}
            <p class="text-white/80 text-lg leading-relaxed mb-8">
                Brindamos un hogar cálido, atención integral y compañía a nuestros adultos mayores.
                Cada día trabajamos para que nuestra familia Nazareth viva con plenitud y alegría.
            </p>

            {{-- CTAs --}}
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('website.donations') }}"
                   class="inline-flex items-center justify-center bg-nazareth-gold text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-500 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue">
                    Apoyar la fundación
                </a>
                <a href="{{ route('website.activities.index') }}"
                   class="inline-flex items-center justify-center border-2 border-white text-white px-6 py-3 rounded-lg font-medium hover:bg-white/10 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-nazareth-blue">
                    Ver actividades
                </a>
            </div>
        </div>

        {{-- Fila de impacto --}}
        <div class="mt-16 grid grid-cols-3 gap-6 max-w-lg">
            <div class="text-center">
                <p class="text-3xl font-semibold text-nazareth-gold">+20</p>
                <p class="text-white/70 text-sm mt-1">Años de servicio</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-semibold text-nazareth-gold">+50</p>
                <p class="text-white/70 text-sm mt-1">Residentes atendidos</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-semibold text-nazareth-gold">+30</p>
                <p class="text-white/70 text-sm mt-1">Voluntarios activos</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     ÚLTIMAS ACTIVIDADES
     ══════════════════════════════════════════ --}}
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-2xl md:text-3xl font-medium text-nazareth-blue">
                Nuestras actividades recientes
            </h2>
        </div>

        @if($activities->isEmpty())
            <div class="text-center py-12 bg-nazareth-gray rounded-xl">
                <p class="text-gray-500 text-lg">Próximamente compartiremos nuestras actividades.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activities as $activity)
                    <a href="{{ route('website.activities.show', $activity->slug) }}"
                       class="group block rounded-xl overflow-hidden shadow hover:shadow-lg transition-shadow bg-white">
                        @if($activity->featuredImage)
                            <div class="overflow-hidden">
                                <img src="{{ Storage::url($activity->featuredImage->file_path) }}"
                                     alt="{{ $activity->featuredImage->alt_text }}"
                                     class="w-full aspect-video object-cover group-hover:scale-105 transition-transform duration-200"
                                     loading="lazy">
                            </div>
                        @else
                            <div class="w-full aspect-video bg-nazareth-gray flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <p class="text-sm text-gray-400">{{ $activity->published_at?->format('d M Y') }}</p>
                            <h3 class="font-medium text-gray-900 mt-1">{{ $activity->title }}</h3>
                            @if($activity->excerpt)
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $activity->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('website.activities.index') }}"
               class="inline-flex items-center text-nazareth-blue hover:text-nazareth-light font-medium transition-colors focus:outline-none focus:underline">
                Ver todas las actividades
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     PRÓXIMOS EVENTOS
     ══════════════════════════════════════════ --}}
<section class="bg-nazareth-gray py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl md:text-3xl font-medium text-nazareth-blue mb-10">
            Próximos eventos
        </h2>

        @if($events->isEmpty())
            <div class="text-center py-10">
                <p class="text-gray-500">No hay eventos próximos por el momento.</p>
            </div>
        @else
            <div class="space-y-4 max-w-2xl">
                @foreach($events as $event)
                    <div class="flex items-start gap-4 bg-white rounded-xl p-4 shadow-sm">
                        {{-- Insignia de fecha --}}
                        <div class="flex-shrink-0 bg-nazareth-blue text-white rounded-lg px-3 py-2 text-center min-w-[56px]">
                            <p class="text-xl font-semibold leading-none">{{ $event->start_date->format('d') }}</p>
                            <p class="text-xs uppercase tracking-wide mt-0.5">{{ $event->start_date->translatedFormat('M') }}</p>
                        </div>
                        {{-- Información --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-gray-900 truncate">{{ $event->title }}</h3>
                            @if($event->location)
                                <p class="text-sm text-gray-500 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('website.events.index') }}"
               class="inline-flex items-center text-nazareth-blue hover:text-nazareth-light font-medium transition-colors focus:outline-none focus:underline">
                Ver todos los eventos
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CÓMO APOYAR
     ══════════════════════════════════════════ --}}
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-medium text-nazareth-blue">
                ¿Cómo puedes apoyarnos?
            </h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto leading-relaxed">
                Cada gesto cuenta. Hay diferentes maneras de contribuir con el bienestar
                de nuestros adultos mayores.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Donación monetaria --}}
            <div class="bg-nazareth-gray rounded-xl p-6 border-l-4 border-nazareth-gold">
                <div class="flex items-center justify-center w-12 h-12 bg-nazareth-gold/10 rounded-lg mb-4">
                    <svg class="w-6 h-6 text-nazareth-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-medium text-gray-900 text-lg mb-2">Donación monetaria</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">
                    Tu aporte económico nos permite cubrir las necesidades básicas y
                    especiales de nuestros residentes.
                </p>
                <a href="{{ route('website.donations') }}"
                   class="text-nazareth-blue hover:text-nazareth-light text-sm font-medium transition-colors focus:outline-none focus:underline">
                    Conocer opciones de donación →
                </a>
            </div>

            {{-- Donación en especie --}}
            <div class="bg-nazareth-gray rounded-xl p-6 border-l-4 border-nazareth-gold">
                <div class="flex items-center justify-center w-12 h-12 bg-nazareth-gold/10 rounded-lg mb-4">
                    <svg class="w-6 h-6 text-nazareth-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="font-medium text-gray-900 text-lg mb-2">Donación en especie</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">
                    Alimentos, ropa, medicamentos y artículos de aseo son siempre
                    bienvenidos para nuestra familia Nazareth.
                </p>
                <a href="{{ route('website.contact') }}"
                   class="text-nazareth-blue hover:text-nazareth-light text-sm font-medium transition-colors focus:outline-none focus:underline">
                    Contáctanos para coordinar →
                </a>
            </div>

            {{-- Voluntariado --}}
            <div class="bg-nazareth-gray rounded-xl p-6 border-l-4 border-nazareth-gold">
                <div class="flex items-center justify-center w-12 h-12 bg-nazareth-gold/10 rounded-lg mb-4">
                    <svg class="w-6 h-6 text-nazareth-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="font-medium text-gray-900 text-lg mb-2">Voluntariado</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">
                    Tu tiempo y compañía son invaluables. Únete a nuestros programas
                    de visitas y actividades recreativas.
                </p>
                <a href="{{ route('website.contact') }}"
                   class="text-nazareth-blue hover:text-nazareth-light text-sm font-medium transition-colors focus:outline-none focus:underline">
                    Ser voluntario →
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CTA DONACIÓN FINAL
     ══════════════════════════════════════════ --}}
<section class="bg-nazareth-blue py-12 text-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl md:text-3xl font-medium text-white mb-4">
            Tu apoyo hace la diferencia
        </h2>
        <p class="text-white/70 leading-relaxed mb-8">
            Con tu contribución seguimos construyendo un hogar lleno de amor, respeto y dignidad
            para nuestros adultos mayores.
        </p>
        <a href="{{ route('website.donations') }}"
           class="inline-flex items-center justify-center bg-nazareth-gold text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-amber-500 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue">
            Hacer una donación
        </a>
    </div>
</section>

@endsection
