@extends('layouts.public')

@section('meta_title', 'Actividades')
@section('meta_description', 'Nuestra agenda semanal combina terapias, celebraciones y momentos de fe. Todo pensado para que cada residente se sienta útil, conectado y querido.')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "@id": "{{ url()->current() }}#webpage",
  "url": "{{ url()->current() }}",
  "name": "Actividades · Fundación Centro de Bienestar del Anciano Nazareth",
  "description": "Nuestra agenda semanal combina terapias, celebraciones y momentos de fe.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "inLanguage": "es-CO"
}
</script>
@endpush

@push('styles')
<style>
.act-item { transition: box-shadow .2s, transform .2s, border-color .2s; }
.act-item:hover { box-shadow: 0 8px 24px rgba(10,107,115,.12); transform: translateY(-2px); border-color: #9ED7DC; }
.act-item:hover .act-photo img { transform: scale(1.05); }
.act-photo img { transition: transform .4s; }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-b from-nazareth-50 to-white pt-[72px] pb-10 border-b border-nazareth-100">
    <div class="max-w-[900px] mx-auto px-6">
        <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Vida en el hogar</span>
        <h1 class="font-display text-[clamp(36px,4.5vw,48px)] text-nazareth-blue leading-tight mb-4 tracking-tight">
            Actividades que mantienen el cuerpo ágil y el alma despierta
        </h1>
        <p class="text-[18px] text-[#4B5A5E] max-w-[58ch] leading-relaxed">
            Nuestra agenda semanal combina terapias profesionales, celebraciones familiares y momentos de fe. Todo pensado para que cada residente se sienta útil, conectado y querido.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     GRID DE ACTIVIDADES
     ══════════════════════════════════════════ --}}
<section class="py-14">
    <div class="max-w-[1200px] mx-auto px-6">

        @if($activities->isEmpty())
            <div class="text-center py-20 bg-nazareth-50 rounded-[16px]">
                <svg class="w-14 h-14 text-nazareth-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-[#4B5A5E] text-lg">Próximamente compartiremos nuestras actividades.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
                @foreach($activities as $activity)
                <article class="act-item bg-white border border-[#E3EAEB] rounded-[16px] overflow-hidden flex flex-col">

                    {{-- Foto --}}
                    <div class="act-photo relative overflow-hidden bg-nazareth-100" style="aspect-ratio:4/3">
                        @if($activity->featuredImage)
                            <img src="{{ Storage::url($activity->featuredImage->file_path) }}"
                                 alt="{{ $activity->featuredImage->alt_text }}"
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-nazareth-100">
                                <svg class="w-12 h-12 text-nazareth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Cuerpo --}}
                    <div class="flex-1 flex flex-col p-[22px]">
                        <h3 class="text-[19px] font-semibold text-nazareth-ink mb-2 leading-snug">{{ $activity->title }}</h3>
                        @if($activity->excerpt)
                            <p class="text-[14px] text-[#4B5A5E] leading-relaxed mb-4 flex-1">{{ Str::limit($activity->excerpt, 120) }}</p>
                        @else
                            <div class="flex-1"></div>
                        @endif

                        <div class="flex items-center justify-between pt-[14px] border-t border-[#E3EAEB] text-[13px]">
                            @if($activity->published_at)
                                <span class="inline-flex items-center gap-1.5 text-[#9CA3AF]">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                    </svg>
                                    {{ $activity->published_at->translatedFormat('d M Y') }}
                                </span>
                            @else
                                <span></span>
                            @endif
                            <a href="{{ route('website.activities.show', $activity->slug) }}"
                               class="font-semibold text-nazareth-700 hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                                Ver más →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            @if($activities->hasPages())
                <div class="mt-12">{{ $activities->links() }}</div>
            @endif
        @endif

    </div>
</section>

@endsection
