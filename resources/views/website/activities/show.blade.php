@extends('layouts.public')

@section('meta_title', $activity->title)
@section('meta_description', $activity->excerpt ?? Str::limit(strip_tags($activity->content), 160))

@if($activity->featuredImage)
    @section('og_image', Storage::url($activity->featuredImage->file_path))
@endif

@section('content')

{{-- ══════════════════════════════════════════
     ENCABEZADO / BREADCRUMB
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-r from-nazareth-blue to-nazareth-light py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav aria-label="Ruta de navegación" class="mb-4">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-white/70">
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
                    <a href="{{ route('website.activities.index') }}"
                       class="hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                        Actividades
                    </a>
                </li>
                <li aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>
                    <span class="text-white font-medium truncate max-w-xs block" aria-current="page">
                        {{ $activity->title }}
                    </span>
                </li>
            </ol>
        </nav>

        {{-- Fecha --}}
        @if($activity->published_at)
            <p class="text-white/70 text-sm mb-3">
                {{ $activity->published_at->translatedFormat('d \d\e F \d\e Y') }}
            </p>
        @endif

        {{-- Título --}}
        <h1 class="text-2xl md:text-3xl font-medium text-white leading-snug">
            {{ $activity->title }}
        </h1>

        @if($activity->excerpt)
            <p class="text-white/80 mt-3 text-base leading-relaxed max-w-2xl">
                {{ $activity->excerpt }}
            </p>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════
     IMAGEN DESTACADA
     ══════════════════════════════════════════ --}}
@if($activity->featuredImage)
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <img src="{{ Storage::url($activity->featuredImage->file_path) }}"
             alt="{{ $activity->featuredImage->alt_text }}"
             class="w-full max-h-96 object-cover rounded-xl shadow-lg">
    </div>
@endif

{{-- ══════════════════════════════════════════
     CONTENIDO PRINCIPAL
     ══════════════════════════════════════════ --}}
<section class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <article class="prose prose-lg max-w-none
                        prose-headings:font-medium prose-headings:text-nazareth-blue
                        prose-a:text-nazareth-blue prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl">
            {!! $activity->content !!}
        </article>

        {{-- Enlace de regreso --}}
        <div class="mt-10 pt-6 border-t border-gray-100">
            <a href="{{ route('website.activities.index') }}"
               class="inline-flex items-center text-nazareth-blue hover:text-nazareth-light font-medium transition-colors focus:outline-none focus:underline">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                Volver a actividades
            </a>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     ACTIVIDADES RELACIONADAS
     ══════════════════════════════════════════ --}}
@if($related->isNotEmpty())
<section class="bg-nazareth-gray py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-medium text-nazareth-blue mb-8">
            Más actividades
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($related as $item)
                <a href="{{ route('website.activities.show', $item->slug) }}"
                   class="group block rounded-xl overflow-hidden shadow hover:shadow-lg transition-shadow bg-white">

                    @if($item->featuredImage)
                        <div class="overflow-hidden">
                            <img src="{{ Storage::url($item->featuredImage->file_path) }}"
                                 alt="{{ $item->featuredImage->alt_text }}"
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
                        <p class="text-sm text-gray-400">{{ $item->published_at?->format('d M Y') }}</p>
                        <h3 class="font-medium text-gray-900 mt-1">{{ $item->title }}</h3>
                        @if($item->excerpt)
                            <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $item->excerpt }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

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
@endif

@endsection
