@extends('layouts.public')

@section('meta_title', $gallery->title)
@section('meta_description', $gallery->description ?? 'Galería fotográfica de la Fundación Hogar del Anciano Nazareth.')

@section('content')
{{-- Page header --}}
<div class="bg-nazareth-blue text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav aria-label="Breadcrumb" class="text-sm text-white/60 mb-2">
            <ol class="flex items-center gap-1">
                <li><a href="{{ route('website.home') }}" class="hover:text-white transition-colors">Inicio</a></li>
                <li aria-hidden="true"><span class="mx-1">/</span></li>
                <li><a href="{{ route('website.galleries.index') }}" class="hover:text-white transition-colors">Galerías</a></li>
                <li aria-hidden="true"><span class="mx-1">/</span></li>
                <li><span class="text-white" aria-current="page">{{ $gallery->title }}</span></li>
            </ol>
        </nav>
        <h1 class="text-3xl font-medium">{{ $gallery->title }}</h1>
        @if($gallery->description)
            <p class="mt-2 text-white/80 leading-relaxed max-w-2xl">{{ $gallery->description }}</p>
        @endif
    </div>
</div>

<main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div x-data="galleryLightbox()" @keydown.escape.window="close()">

        {{-- Image grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($gallery->images as $index => $image)
                @if($image->media)
                <button
                    @click="open({{ $index }})"
                    class="group relative aspect-square overflow-hidden rounded-lg focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2"
                    aria-label="Ver foto {{ $index + 1 }}: {{ $image->media->alt_text ?? $image->caption ?? $gallery->title }}"
                >
                    <img
                        src="{{ Storage::url($image->media->file_path) }}"
                        alt="{{ $image->media->alt_text ?? $image->caption ?? '' }}"
                        loading="lazy"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                    >
                    @if($image->caption)
                        <div class="absolute inset-x-0 bottom-0 bg-black/60 text-white text-xs p-2 translate-y-full group-hover:translate-y-0 transition-transform duration-200">
                            {{ $image->caption }}
                        </div>
                    @endif
                </button>
                @endif
            @endforeach
        </div>

        {{-- Empty state --}}
        @if($gallery->images->isEmpty())
            <p class="text-center text-gray-500 py-12">Esta galería aún no tiene imágenes.</p>
        @endif

        {{-- Lightbox overlay --}}
        <div
            x-show="active"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/90"
            x-cloak
            role="dialog"
            aria-modal="true"
            :aria-label="'Foto ' + (currentIndex + 1) + ' de ' + images.length"
        >
            {{-- Close button --}}
            <button
                @click="close()"
                class="absolute top-4 right-4 text-white/80 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded p-2"
                aria-label="Cerrar galería"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Prev button --}}
            <button
                @click="prev()"
                x-show="images.length > 1"
                class="absolute left-4 text-white/80 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded p-2"
                aria-label="Foto anterior"
            >
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Image --}}
            <img
                :src="images[currentIndex]?.src"
                :alt="images[currentIndex]?.alt"
                class="max-w-[90vw] max-h-[85vh] object-contain rounded"
                x-cloak
            >

            {{-- Caption --}}
            <div
                x-show="images[currentIndex]?.caption"
                x-text="images[currentIndex]?.caption"
                class="absolute bottom-4 left-0 right-0 text-center text-white/80 text-sm px-8"
                x-cloak
            ></div>

            {{-- Counter --}}
            <div class="absolute bottom-4 right-4 text-white/60 text-sm" x-text="(currentIndex + 1) + ' / ' + images.length"></div>

            {{-- Next button --}}
            <button
                @click="next()"
                x-show="images.length > 1"
                class="absolute right-4 text-white/80 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded p-2 mr-12"
                aria-label="Foto siguiente"
            >
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7 7 7"/>
                </svg>
            </button>
        </div>

    </div>

    {{-- Back link --}}
    <div class="mt-10 pt-6 border-t border-gray-100">
        <a href="{{ route('website.galleries.index') }}" class="text-nazareth-blue hover:underline text-sm">
            ← Volver a Galerías
        </a>
    </div>
</main>
@endsection

@push('scripts')
@php
    $lightboxImages = $gallery->images
        ->filter(fn ($i) => $i->media)
        ->map(fn ($i) => [
            'src'     => \Illuminate\Support\Facades\Storage::url($i->media->file_path),
            'alt'     => $i->media->alt_text ?? $i->caption ?? '',
            'caption' => $i->caption,
        ])
        ->values()
        ->toArray();
@endphp
<script>
function galleryLightbox() {
    return {
        active: false,
        currentIndex: 0,
        images: @json($lightboxImages),
        open(index) { this.active = true; this.currentIndex = index; document.body.style.overflow = 'hidden'; },
        close() { this.active = false; document.body.style.overflow = ''; },
        next() { this.currentIndex = (this.currentIndex + 1) % this.images.length; },
        prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length; },
    }
}
</script>
@endpush
