@extends('layouts.public')

@section('meta_title', 'Eventos')
@section('meta_description', 'Conoce los eventos y celebraciones organizados por la Fundación Hogar del Anciano Nazareth.')

@section('content')

{{-- ══════════════════════════════════════════
     ENCABEZADO DE SECCIÓN
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-r from-nazareth-blue to-nazareth-light py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav aria-label="Ruta de navegación" class="mb-4">
            <ol class="flex items-center gap-2 text-sm text-white/70">
                <li>
                    <a href="{{ route('website.home') }}"
                       class="hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                        Inicio
                    </a>
                </li>
                <li aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>
                    <span class="text-white font-medium" aria-current="page">Eventos</span>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-medium text-white">
            Eventos y celebraciones
        </h1>
        <p class="text-white/80 mt-3 text-lg leading-relaxed max-w-2xl">
            Acompáñanos en nuestros eventos y celebraciones especiales junto a la familia Nazareth.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     PRÓXIMOS EVENTOS
     ══════════════════════════════════════════ --}}
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="text-2xl font-medium text-nazareth-blue mb-6">Próximos eventos</h2>

        @if($upcoming->isEmpty())
            <div class="text-center py-10 bg-nazareth-gray rounded-xl">
                <svg class="w-14 h-14 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 text-lg">No hay eventos próximos en este momento.</p>
                <p class="text-gray-400 text-sm mt-1">Vuelve pronto para conocer nuestras próximas actividades.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($upcoming as $event)
                    <a href="{{ route('website.events.show', $event->slug) }}"
                       class="group flex flex-col sm:flex-row gap-4 bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md hover:border-nazareth-blue/30 transition-all focus:outline-none focus:ring-2 focus:ring-nazareth-blue">

                        {{-- Insignia de fecha --}}
                        <div class="flex-shrink-0 flex flex-col items-center justify-center bg-nazareth-blue text-white rounded-xl w-16 h-16 text-center">
                            <span class="text-xl font-medium leading-none">{{ $event->start_date->format('d') }}</span>
                            <span class="text-xs uppercase leading-none mt-1">{{ $event->start_date->translatedFormat('M') }}</span>
                        </div>

                        {{-- Información del evento --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-gray-900 group-hover:text-nazareth-blue transition-colors text-lg leading-snug">
                                {{ $event->title }}
                            </h3>

                            @if($event->location)
                                <p class="flex items-center gap-1.5 text-sm text-gray-500 mt-1">
                                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </p>
                            @endif

                            @if($event->description)
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $event->description }}
                                </p>
                            @endif
                        </div>

                        {{-- Flecha --}}
                        <div class="flex items-center text-gray-300 group-hover:text-nazareth-blue transition-colors flex-shrink-0">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</section>

{{-- ══════════════════════════════════════════
     EVENTOS PASADOS
     ══════════════════════════════════════════ --}}
@if($past->isNotEmpty())
<section class="bg-nazareth-gray py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="text-2xl font-medium text-nazareth-blue mb-6">Eventos pasados</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($past as $event)
                <a href="{{ route('website.events.show', $event->slug) }}"
                   class="group block rounded-xl overflow-hidden shadow hover:shadow-lg transition-shadow bg-white focus:outline-none focus:ring-2 focus:ring-nazareth-blue">

                    {{-- Imagen destacada --}}
                    @if($event->featuredImage)
                        <div class="overflow-hidden">
                            <img src="{{ Storage::url($event->featuredImage->file_path) }}"
                                 alt="{{ $event->featuredImage->alt_text }}"
                                 class="w-full aspect-video object-cover group-hover:scale-105 transition-transform duration-200"
                                 loading="lazy">
                        </div>
                    @else
                        <div class="w-full aspect-video bg-nazareth-gray flex items-center justify-center border-b border-gray-100">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Contenido de la tarjeta --}}
                    <div class="p-4">
                        <p class="text-sm text-gray-400">{{ $event->start_date->translatedFormat('d \d\e F \d\e Y') }}</p>
                        <h3 class="font-medium text-gray-900 mt-1 group-hover:text-nazareth-blue transition-colors">
                            {{ $event->title }}
                        </h3>
                        @if($event->location)
                            <p class="flex items-center gap-1 text-xs text-gray-400 mt-1.5">
                                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->location }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if($past->hasPages())
            <div class="mt-10">
                {{ $past->links() }}
            </div>
        @endif

    </div>
</section>
@endif

{{-- Estado vacío total --}}
@if($upcoming->isEmpty() && $past->isEmpty())
<section class="bg-nazareth-gray py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-500 text-lg">Próximamente compartiremos nuestros eventos y celebraciones.</p>
    </div>
</section>
@endif

@endsection
