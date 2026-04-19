@extends('layouts.public')

@section('meta_title', $event->title)
@section('meta_description', Str::limit(strip_tags($event->description ?? $event->title), 160))

@if($event->featuredImage)
    @section('og_image', Storage::url($event->featuredImage->file_path))
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
                    <a href="{{ route('website.events.index') }}"
                       class="hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                        Eventos
                    </a>
                </li>
                <li aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>
                    <span class="text-white font-medium truncate max-w-xs block" aria-current="page">
                        {{ $event->title }}
                    </span>
                </li>
            </ol>
        </nav>

        {{-- Fecha --}}
        <p class="text-white/70 text-sm mb-3">
            {{ $event->start_date->translatedFormat('d \d\e F \d\e Y') }}
            @if($event->end_date && $event->end_date->ne($event->start_date))
                &ndash; {{ $event->end_date->translatedFormat('d \d\e F \d\e Y') }}
            @endif
        </p>

        {{-- Título --}}
        <h1 class="text-2xl md:text-3xl font-medium text-white leading-snug">
            {{ $event->title }}
        </h1>

        {{-- Ubicación --}}
        @if($event->location)
            <p class="flex items-center gap-2 text-white/80 mt-3 text-sm">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $event->location }}
            </p>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════
     IMAGEN DESTACADA
     ══════════════════════════════════════════ --}}
@if($event->featuredImage)
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <img src="{{ Storage::url($event->featuredImage->file_path) }}"
             alt="{{ $event->featuredImage->alt_text }}"
             class="w-full max-h-96 object-cover rounded-xl shadow-lg"
             loading="lazy">
    </div>
@endif

{{-- ══════════════════════════════════════════
     DESCRIPCIÓN DEL EVENTO
     ══════════════════════════════════════════ --}}
<section class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($event->description)
            <article class="prose prose-lg max-w-none
                            prose-headings:font-medium prose-headings:text-nazareth-blue
                            prose-a:text-nazareth-blue prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-xl">
                {!! nl2br(e($event->description)) !!}
            </article>
        @endif

        {{-- Enlace de regreso --}}
        <div class="mt-10 pt-6 border-t border-gray-100">
            <a href="{{ route('website.events.index') }}"
               class="inline-flex items-center text-nazareth-blue hover:text-nazareth-light font-medium transition-colors focus:outline-none focus:underline">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                Volver a eventos
            </a>
        </div>

    </div>
</section>

@endsection
