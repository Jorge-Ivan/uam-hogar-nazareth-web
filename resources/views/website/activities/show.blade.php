@extends('layouts.public')

@section('meta_title', $activity->title)
@section('meta_description', $activity->excerpt ?? Str::limit(strip_tags($activity->content), 160))

@if($activity->featuredImage)
    @section('og_image', Storage::url($activity->featuredImage->file_path))
@endif

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "@id": "{{ url()->current() }}#article",
  "headline": "{{ $activity->title }}",
  "description": "{{ $activity->excerpt ?? Str::limit(strip_tags($activity->content ?? ''), 160) }}",
  "url": "{{ url()->current() }}",
  "datePublished": "{{ $activity->published_at?->toIso8601String() ?? $activity->created_at->toIso8601String() }}",
  "dateModified": "{{ $activity->updated_at->toIso8601String() }}"@if($activity->featuredImage),
  "image": {
    "@type": "ImageObject",
    "url": "{{ Storage::url($activity->featuredImage->file_path) }}",
    "description": "{{ $activity->featuredImage->alt_text }}"
  }@endif,
  "publisher": { "@id": "{{ url('/') }}/#organization" },
  "author": { "@id": "{{ url('/') }}/#organization" },
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "inLanguage": "es-CO",
  "articleSection": "Actividades"
}
</script>
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
                <li><a href="{{ route('website.activities.index') }}" class="hover:text-nazareth-blue transition-colors">Actividades</a></li>
                <li aria-hidden="true"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-nazareth-ink font-medium truncate max-w-[28ch]" aria-current="page">{{ $activity->title }}</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ══════════════════════════════════════════
     TARJETA DE DETALLE
     ══════════════════════════════════════════ --}}
<section class="py-14 bg-nazareth-paper">
    <div class="max-w-[1200px] mx-auto px-6">

        <div class="bg-white border border-[#E3EAEB] rounded-[20px] overflow-hidden shadow-md grid grid-cols-1 md:grid-cols-2">

            {{-- Imagen --}}
            <div class="bg-nazareth-100" style="aspect-ratio:1/1; min-height:300px">
                @if($activity->featuredImage)
                    <img src="{{ Storage::url($activity->featuredImage->file_path) }}"
                         alt="{{ $activity->featuredImage->alt_text }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-nazareth-100">
                        <svg class="w-16 h-16 text-nazareth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-10 md:p-12 flex flex-col justify-center">
                @if($activity->published_at)
                    <span class="inline-block text-xs font-semibold tracking-[.12em] uppercase text-nazareth-700 mb-3">
                        {{ $activity->published_at->translatedFormat('d \d\e F \d\e Y') }}
                    </span>
                @endif

                <h1 class="font-display text-[clamp(24px,3vw,32px)] text-nazareth-ink leading-tight mb-4 tracking-tight">
                    {{ $activity->title }}
                </h1>

                @if($activity->excerpt)
                    <p class="text-[16px] text-[#4B5A5E] leading-relaxed mb-5">{{ $activity->excerpt }}</p>
                @endif

                @if($activity->content)
                    <div class="prose prose-sm max-w-none text-[#4B5A5E]
                                prose-headings:text-nazareth-blue prose-headings:font-semibold
                                prose-a:text-nazareth-blue prose-img:rounded-xl mb-6">
                        {!! str_replace(['&amp;nbsp;', '&nbsp;', "\u{00A0}"], ' ', $activity->content) !!}
                    </div>
                @endif

                <div class="flex flex-wrap gap-3 mt-2">
                    <a href="{{ route('website.galleries.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-nazareth-blue text-white text-[14px] font-semibold rounded-[10px] hover:bg-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
                        Ver galerías
                    </a>
                    <a href="{{ route('website.contact') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 border border-nazareth-blue text-nazareth-blue text-[14px] font-semibold rounded-[10px] hover:bg-nazareth-50 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
                        Ser voluntario
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('website.activities.index') }}"
               class="inline-flex items-center gap-2 text-[14px] font-semibold text-nazareth-700 hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
<section class="py-14 border-t border-[#E3EAEB]">
    <div class="max-w-[1200px] mx-auto px-6">
        <h2 class="font-display text-[26px] text-nazareth-blue mb-8 tracking-tight">Más actividades</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($related as $item)
            <a href="{{ route('website.activities.show', $item->slug) }}"
               class="group block bg-white border border-[#E3EAEB] rounded-[16px] overflow-hidden hover:shadow-md hover:border-nazareth-200 transition-all">
                <div class="overflow-hidden bg-nazareth-100" style="aspect-ratio:4/3">
                    @if($item->featuredImage)
                        <img src="{{ Storage::url($item->featuredImage->file_path) }}"
                             alt="{{ $item->featuredImage->alt_text }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-nazareth-100">
                            <svg class="w-10 h-10 text-nazareth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    @if($item->published_at)
                        <p class="text-[12px] text-[#9CA3AF] mb-1">{{ $item->published_at->translatedFormat('d M Y') }}</p>
                    @endif
                    <h3 class="text-[16px] font-semibold text-nazareth-ink group-hover:text-nazareth-blue transition-colors leading-snug">{{ $item->title }}</h3>
                    @if($item->excerpt)
                        <p class="text-[13px] text-[#4B5A5E] mt-1.5 line-clamp-2">{{ $item->excerpt }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
