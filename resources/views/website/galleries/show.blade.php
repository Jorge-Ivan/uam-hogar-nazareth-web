@extends('layouts.public')

@section('meta_title', $gallery->title)
@section('meta_description', $gallery->description ?? 'Galería fotográfica de la Fundación Centro de Bienestar del Anciano Nazareth.')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ImageGallery",
  "@id": "{{ url()->current() }}#gallery",
  "name": "{{ $gallery->title }}",
  "description": "{{ $gallery->description ?? 'Galería fotográfica de la Fundación Centro de Bienestar del Anciano Nazareth.' }}",
  "url": "{{ url()->current() }}",
  "dateModified": "{{ $gallery->updated_at->toIso8601String() }}",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "publisher": { "@id": "{{ url('/') }}/#organization" },
  "inLanguage": "es-CO"
}
</script>
@endpush

@push('styles')
<style>
.masonry { columns: 3 240px; column-gap: 16px; }
.masonry-item { break-inside: avoid; margin-bottom: 16px; }
.masonry-item img { transition: opacity .15s; cursor: pointer; }
.masonry-item img:hover { opacity: .85; }
@media (max-width: 600px) { .masonry { columns: 2 140px; } }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-b from-nazareth-50 to-white pt-[72px] pb-10 border-b border-nazareth-100">
    <div class="max-w-[1200px] mx-auto px-6">
        <nav aria-label="Ruta de navegación" class="mb-4">
            <ol class="flex flex-wrap items-center gap-1.5 text-sm text-[#5A6A6E]">
                <li><a href="{{ route('website.home') }}" class="hover:text-nazareth-blue transition-colors">Inicio</a></li>
                <li aria-hidden="true"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li><a href="{{ route('website.galleries.index') }}" class="hover:text-nazareth-blue transition-colors">Galerías</a></li>
                <li aria-hidden="true"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-nazareth-ink font-medium truncate max-w-[28ch]" aria-current="page">{{ $gallery->title }}</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ══════════════════════════════════════════
     GALERÍA MASONRY
     ══════════════════════════════════════════ --}}
<section class="py-14 bg-nazareth-paper">
    <div class="max-w-[1200px] mx-auto px-6">

        <div x-data="galleryLightbox()" @keydown.escape.window="close()">

            {{-- Encabezado --}}
            <div class="flex items-end justify-between mb-8 flex-wrap gap-4">
                <div>
                    <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-2">Vista de álbum</span>
                    <h1 class="font-display text-[clamp(24px,3vw,34px)] text-nazareth-ink tracking-tight mb-1">{{ $gallery->title }}</h1>
                    @if($gallery->description)
                        <p class="text-[15px] text-[#4B5A5E]">{{ $gallery->description }}</p>
                    @endif
                    @if($gallery->images->isNotEmpty())
                        <p class="text-[14px] text-[#9CA3AF] mt-1">{{ $gallery->images->count() }} {{ $gallery->images->count() === 1 ? 'fotografía' : 'fotografías' }}</p>
                    @endif
                </div>
                <a href="{{ route('website.galleries.index') }}"
                   class="shrink-0 px-5 py-2.5 border border-nazareth-blue text-nazareth-blue text-[14px] font-semibold rounded-[10px] hover:bg-nazareth-50 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
                    ← Volver a galerías
                </a>
            </div>

            {{-- Masonry --}}
            @if($gallery->images->isEmpty())
                <div class="text-center py-16 bg-nazareth-50 rounded-[16px]">
                    <p class="text-[#4B5A5E]">Esta galería aún no tiene imágenes.</p>
                </div>
            @else
                <div class="masonry">
                    @foreach($gallery->images as $index => $image)
                        @if($image->media)
                        <div class="masonry-item">
                            <button @click="open({{ $index }})"
                                    class="block w-full focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded-[10px] overflow-hidden"
                                    aria-label="Ver foto {{ $index + 1 }}{{ $image->caption ? ': ' . $image->caption : '' }}">
                                <img src="{{ Storage::url($image->media->file_path) }}"
                                     alt="{{ $image->media->alt_text ?? $image->caption ?? $gallery->title }}"
                                     loading="lazy"
                                     class="w-full rounded-[10px]">
                            </button>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif

            {{-- Lightbox --}}
            <div x-show="active"
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
                 :aria-label="'Foto ' + (currentIndex + 1) + ' de ' + images.length">

                <button @click="close()"
                        class="absolute top-4 right-4 text-white/80 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded p-2"
                        aria-label="Cerrar galería">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <button @click="prev()"
                        x-show="images.length > 1"
                        class="absolute left-4 text-white/80 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded p-2"
                        aria-label="Foto anterior">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <img :src="images[currentIndex]?.src"
                     :alt="images[currentIndex]?.alt"
                     class="max-w-[90vw] max-h-[85vh] object-contain rounded"
                     x-cloak>

                <div x-show="images[currentIndex]?.caption"
                     x-text="images[currentIndex]?.caption"
                     class="absolute bottom-10 left-0 right-0 text-center text-white/80 text-sm px-8"
                     x-cloak></div>

                <div class="absolute bottom-4 right-4 text-white/60 text-sm"
                     x-text="(currentIndex + 1) + ' / ' + images.length"></div>

                <button @click="next()"
                        x-show="images.length > 1"
                        class="absolute right-4 text-white/80 hover:text-white focus:outline-none focus:ring-2 focus:ring-white rounded p-2 mr-12"
                        aria-label="Foto siguiente">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>
</section>

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
