@extends('layouts.public')

@section('meta_title', $event->title)
@section('meta_description', Str::limit(strip_tags($event->description ?? $event->title), 160))

@if($event->featuredImage)
    @section('og_image', Storage::url($event->featuredImage->file_path))
@endif

@push('schema')
<script type="application/ld+json">
@php
$schema = [
    '@context'            => 'https://schema.org',
    '@type'               => 'Event',
    '@id'                 => url()->current() . '#event',
    'name'                => $event->title,
    'description'         => Str::limit(strip_tags($event->description ?? $event->title), 200),
    'url'                 => url()->current(),
    'startDate'           => $event->start_date->toIso8601String(),
    'organizer'           => ['@id' => url('/') . '/#organization'],
    'eventStatus'         => 'https://schema.org/EventScheduled',
    'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
    'inLanguage'          => 'es-CO',
];
if ($event->end_date) {
    $schema['endDate'] = $event->end_date->toIso8601String();
}
if ($event->location) {
    $schema['location'] = [
        '@type'   => 'Place',
        'name'    => $event->location,
        'address' => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'La Virginia',
            'addressRegion'   => 'Risaralda',
            'addressCountry'  => 'CO',
        ],
    ];
}
if ($event->featuredImage) {
    $schema['image'] = Storage::url($event->featuredImage->file_path);
}
echo json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp
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
                <li><a href="{{ route('website.events.index') }}" class="hover:text-nazareth-blue transition-colors">Eventos</a></li>
                <li aria-hidden="true"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-nazareth-ink font-medium truncate max-w-[28ch]" aria-current="page">{{ $event->title }}</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ══════════════════════════════════════════
     TARJETA PRINCIPAL
     ══════════════════════════════════════════ --}}
<section class="py-14 bg-nazareth-paper">
    <div class="max-w-[1200px] mx-auto px-6">

        <article class="bg-white border border-[#E3EAEB] rounded-[20px] overflow-hidden shadow-md grid grid-cols-1 md:grid-cols-[1.1fr_1fr]">

            {{-- Imagen --}}
            <div class="relative overflow-hidden bg-nazareth-200" style="aspect-ratio:5/4; min-height:280px">
                @if($event->featuredImage)
                    <img src="{{ Storage::url($event->featuredImage->file_path) }}"
                         alt="{{ $event->featuredImage->alt_text }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-nazareth-50">
                        <div class="flex flex-col items-center bg-white border border-nazareth-100 shadow-sm rounded-[16px] px-8 py-6 text-center select-none">
                            <span class="text-[12px] font-bold text-nazareth-700 uppercase tracking-[.16em]">{{ $event->start_date->translatedFormat('M') }}</span>
                            <span class="font-display text-[64px] font-semibold text-nazareth-blue leading-none my-2">{{ $event->start_date->format('d') }}</span>
                            <span class="text-[12px] text-[#9CA3AF]">{{ $event->start_date->format('Y') }}</span>
                        </div>
                    </div>
                @endif

                @php $isOngoing = $event->start_date->lte(now()) && ($event->end_date === null || $event->end_date->gte(now())); @endphp
                @if($isOngoing)
                    <span class="absolute top-5 left-5 bg-nazareth-green text-white text-[12px] font-semibold tracking-[.06em] uppercase px-3 py-1.5 rounded-full">En curso</span>
                @elseif($event->start_date->isFuture())
                    <span class="absolute top-5 left-5 bg-nazareth-gold text-white text-[12px] font-semibold tracking-[.06em] uppercase px-3 py-1.5 rounded-full">Próximo</span>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex flex-col justify-center px-10 py-12">
                <span class="inline-flex items-center gap-2 text-nazareth-700 font-semibold text-[14px] mb-4">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    {{ $event->start_date->translatedFormat('l d \d\e F \d\e Y') }}
                    @if($event->end_date && $event->end_date->ne($event->start_date))
                        – {{ $event->end_date->translatedFormat('d \d\e F \d\e Y') }}
                    @endif
                </span>

                <h1 class="font-display text-[clamp(24px,3vw,32px)] text-nazareth-ink leading-tight mb-4 tracking-tight">
                    {{ $event->title }}
                </h1>

                @if($event->description)
                    <p class="text-[16px] text-[#4B5A5E] leading-relaxed mb-6">{{ $event->description }}</p>
                @endif

                {{-- Meta --}}
                <div class="grid grid-cols-2 gap-5 p-5 bg-nazareth-50 rounded-[12px] mb-7">
                    <div>
                        <strong class="block text-[11px] font-semibold uppercase tracking-[.08em] text-nazareth-700 mb-1">Fecha</strong>
                        <span class="text-[15px] font-medium text-nazareth-ink">{{ $event->start_date->translatedFormat('d M Y') }}</span>
                    </div>
                    @if($event->end_date && $event->end_date->ne($event->start_date))
                    <div>
                        <strong class="block text-[11px] font-semibold uppercase tracking-[.08em] text-nazareth-700 mb-1">Hasta</strong>
                        <span class="text-[15px] font-medium text-nazareth-ink">{{ $event->end_date->translatedFormat('d M Y') }}</span>
                    </div>
                    @endif
                    @if($event->location)
                    <div class="{{ $event->end_date && $event->end_date->ne($event->start_date) ? '' : 'col-span-2' }}">
                        <strong class="block text-[11px] font-semibold uppercase tracking-[.08em] text-nazareth-700 mb-1">Lugar</strong>
                        <span class="text-[15px] font-medium text-nazareth-ink">{{ $event->location }}</span>
                    </div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('website.contact') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-nazareth-blue text-white text-[14px] font-semibold rounded-[10px] hover:bg-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
                        Más información
                    </a>
                    <a href="{{ route('website.events.index') }}"
                       class="inline-flex items-center px-5 py-2.5 border border-nazareth-blue text-nazareth-blue text-[14px] font-semibold rounded-[10px] hover:bg-nazareth-50 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
                        ← Todos los eventos
                    </a>
                </div>
            </div>
        </article>

    </div>
</section>

@endsection
