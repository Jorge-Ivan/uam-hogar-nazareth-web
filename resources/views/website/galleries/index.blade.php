@extends('layouts.public')

@section('meta_title', 'Galerías de fotos')
@section('meta_description', 'Momentos de celebraciones, salidas y días corrientes. Las mejores postales del hogar, retrato a retrato.')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "@id": "{{ url()->current() }}#webpage",
  "url": "{{ url()->current() }}",
  "name": "Galerías de fotos · Fundación Centro de Bienestar del Anciano Nazareth",
  "description": "Momentos de celebraciones, salidas y días corrientes del hogar.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "inLanguage": "es-CO"
}
</script>
@endpush

@push('styles')
<style>
.album { transition: transform .25s; }
.album:hover { transform: translateY(-3px); }
.album:hover .album-img { transform: scale(1.05); }
.album-img { transition: transform .4s; }
.album::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(10,107,115,.85));
    pointer-events: none;
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-b from-nazareth-50 to-white pt-[72px] pb-10 border-b border-nazareth-100">
    <div class="max-w-[1200px] mx-auto px-6">
        <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Recuerdos compartidos</span>
        <h1 class="font-display text-[clamp(36px,4.5vw,48px)] text-nazareth-blue leading-tight mb-4 tracking-tight">Galerías</h1>
        <p class="text-[18px] text-[#4B5A5E] max-w-[58ch] leading-relaxed">
            Momentos de celebraciones, salidas y días corrientes. Las mejores postales del hogar, retrato a retrato.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     GRID DE ÁLBUMES
     ══════════════════════════════════════════ --}}
<section class="py-14">
    <div class="max-w-[1200px] mx-auto px-6">

        @if($galleries->isEmpty())
            <div class="text-center py-20 bg-nazareth-50 rounded-[16px]">
                <svg class="w-14 h-14 text-nazareth-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-[#4B5A5E] text-lg">No hay galerías disponibles en este momento.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($galleries as $gallery)
                @php $cover = $gallery->coverImage; @endphp
                <a href="{{ route('website.galleries.show', $gallery->slug) }}"
                   class="album relative block rounded-[16px] overflow-hidden bg-nazareth-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2"
                   style="aspect-ratio:4/5"
                   aria-label="{{ $gallery->title }}">

                    @if($cover && $cover->media)
                        <img src="{{ Storage::url($cover->media->file_path) }}"
                             alt="{{ $cover->media->alt_text ?? $gallery->title }}"
                             loading="lazy"
                             class="album-img w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-nazareth-100">
                            <svg class="w-16 h-16 text-nazareth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    <div class="absolute bottom-5 left-6 right-6 z-10">
                        <h2 class="text-white text-[20px] font-semibold leading-snug mb-1">{{ $gallery->title }}</h2>
                        @if($gallery->images_count > 0)
                            <span class="inline-flex items-center gap-1.5 text-[12px] text-white/85">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
                                </svg>
                                {{ $gallery->images_count }} {{ $gallery->images_count === 1 ? 'foto' : 'fotos' }}
                            </span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>

            @if($galleries->hasPages())
                <div class="mt-12">{{ $galleries->links() }}</div>
            @endif
        @endif

    </div>
</section>

@endsection
