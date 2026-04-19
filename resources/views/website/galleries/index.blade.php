@extends('layouts.public')

@section('meta_title', 'Galerías de fotos')
@section('meta_description', 'Explora las galerías fotográficas de la Fundación Hogar del Anciano Nazareth y conoce nuestras actividades.')

@section('content')
{{-- Page header --}}
<div class="bg-nazareth-blue text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav aria-label="Breadcrumb" class="text-sm text-white/60 mb-2">
            <ol class="flex items-center gap-1">
                <li><a href="{{ route('website.home') }}" class="hover:text-white transition-colors">Inicio</a></li>
                <li aria-hidden="true"><span class="mx-1">/</span></li>
                <li><span class="text-white" aria-current="page">Galerías</span></li>
            </ol>
        </nav>
        <h1 class="text-3xl font-medium">Nuestras galerías</h1>
    </div>
</div>

<main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if($galleries->isEmpty())
        <div class="text-center py-16">
            <p class="text-gray-500 text-lg">No hay galerías disponibles en este momento.</p>
            <a href="{{ route('website.home') }}" class="mt-4 inline-block text-nazareth-blue hover:underline">← Volver al inicio</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galleries as $gallery)
                <a href="{{ route('website.galleries.show', $gallery->slug) }}"
                   class="group block bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">

                    {{-- Cover image --}}
                    <div class="relative aspect-video overflow-hidden bg-nazareth-gray">
                        @php $coverImage = $gallery->images->first(); @endphp
                        @if($coverImage && $coverImage->media)
                            <img
                                src="{{ Storage::url($coverImage->media->file_path) }}"
                                alt="{{ $coverImage->media->alt_text ?? $gallery->title }}"
                                loading="lazy"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-nazareth-gray">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Card body --}}
                    <div class="p-4">
                        <h2 class="font-medium text-gray-900 text-base group-hover:text-nazareth-blue transition-colors duration-200 leading-snug">
                            {{ $gallery->title }}
                        </h2>

                        @if($gallery->images_count > 0)
                            <p class="mt-1 text-sm text-gray-400">
                                {{ $gallery->images_count }} {{ $gallery->images_count === 1 ? 'foto' : 'fotos' }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($galleries->hasPages())
            <div class="mt-10">
                {{ $galleries->links() }}
            </div>
        @endif
    @endif
</main>
@endsection
