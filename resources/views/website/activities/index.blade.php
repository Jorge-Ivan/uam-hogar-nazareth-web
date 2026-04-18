@extends('layouts.public')

@section('meta_title', 'Actividades')
@section('meta_description', 'Conoce las actividades y noticias de la Fundación Hogar del Anciano Nazareth.')

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
                    <span class="text-white font-medium" aria-current="page">Actividades</span>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-medium text-white">
            Nuestras actividades
        </h1>
        <p class="text-white/80 mt-3 text-lg leading-relaxed max-w-2xl">
            Descubre las actividades, celebraciones y momentos especiales que compartimos
            con nuestra familia Nazareth.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     BARRA DE BÚSQUEDA
     ══════════════════════════════════════════ --}}
<section class="bg-nazareth-gray py-6 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('website.activities.index') }}" role="search">
            <div class="flex flex-col sm:flex-row gap-3 max-w-xl">
                <label for="search-activities" class="sr-only">Buscar actividad</label>
                <input
                    id="search-activities"
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar actividad..."
                    class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:border-transparent text-sm"
                >
                <button
                    type="submit"
                    class="inline-flex items-center justify-center bg-nazareth-blue text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2"
                >
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Buscar
                </button>
                @if(request('q'))
                    <a href="{{ route('website.activities.index') }}"
                       class="inline-flex items-center justify-center text-gray-500 hover:text-gray-700 px-3 py-2.5 text-sm transition-colors focus:outline-none focus:underline">
                        Limpiar
                    </a>
                @endif
            </div>
            @if(request('q'))
                <p class="mt-3 text-sm text-gray-500">
                    Resultados para: <span class="font-medium text-gray-700">"{{ request('q') }}"</span>
                    &mdash; {{ $activities->total() }} {{ $activities->total() === 1 ? 'actividad encontrada' : 'actividades encontradas' }}
                </p>
            @endif
        </form>
    </div>
</section>

{{-- ══════════════════════════════════════════
     GRID DE ACTIVIDADES
     ══════════════════════════════════════════ --}}
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($activities->isEmpty())
            <div class="text-center py-16 bg-nazareth-gray rounded-xl">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                @if(request('q'))
                    <p class="text-gray-500 text-lg mb-2">No encontramos actividades con ese término.</p>
                    <a href="{{ route('website.activities.index') }}"
                       class="text-nazareth-blue hover:text-nazareth-light text-sm font-medium transition-colors focus:outline-none focus:underline">
                        Ver todas las actividades
                    </a>
                @else
                    <p class="text-gray-500 text-lg">Próximamente compartiremos nuestras actividades.</p>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activities as $activity)
                    <a href="{{ route('website.activities.show', $activity->slug) }}"
                       class="group block rounded-xl overflow-hidden shadow hover:shadow-lg transition-shadow bg-white">

                        {{-- Imagen destacada --}}
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

                        {{-- Contenido de la tarjeta --}}
                        <div class="p-4">
                            <p class="text-sm text-gray-400">{{ $activity->published_at?->format('d M Y') }}</p>
                            <h2 class="font-medium text-gray-900 mt-1">{{ $activity->title }}</h2>
                            @if($activity->excerpt)
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $activity->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Paginación --}}
            @if($activities->hasPages())
                <div class="mt-10">
                    {{ $activities->links() }}
                </div>
            @endif
        @endif

    </div>
</section>

@endsection
