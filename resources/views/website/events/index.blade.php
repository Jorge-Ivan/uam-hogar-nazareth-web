@extends('layouts.public')

@section('meta_title', 'Eventos')
@section('meta_description', 'Celebraciones, jornadas de recaudación y actividades abiertas a la comunidad. Están todas cordialmente invitadas.')

@section('content')

{{-- ══════════════════════════════════════════
     HERO
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-b from-nazareth-50 to-white pt-[72px] pb-10 border-b border-nazareth-100">
    <div class="max-w-[1200px] mx-auto px-6">
        <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Agenda del hogar</span>
        <h1 class="font-display text-[clamp(36px,4.5vw,48px)] text-nazareth-blue leading-tight mb-4 tracking-tight">Eventos</h1>
        <p class="text-[18px] text-[#4B5A5E] max-w-[58ch] leading-relaxed">
            Celebraciones, jornadas de recaudación y actividades abiertas a la comunidad. Están todas cordialmente invitadas.
        </p>
    </div>
</section>

@php
    $featured  = $upcoming->first();
    $remaining = $upcoming->slice(1);
@endphp

{{-- ══════════════════════════════════════════
     EVENTO DESTACADO
     ══════════════════════════════════════════ --}}
@if($featured)
<section class="py-14">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex items-baseline justify-between mb-6 flex-wrap gap-3">
            <h2 class="font-display text-[26px] text-nazareth-blue tracking-tight">Próximo gran evento</h2>
        </div>

        <article class="grid grid-cols-1 md:grid-cols-[1.1fr_1fr] overflow-hidden bg-white border border-[#E3EAEB] rounded-[20px] shadow-md mb-9">
            {{-- Imagen --}}
            <div class="relative overflow-hidden bg-nazareth-200" style="aspect-ratio:5/4; min-height:260px">
                @if($featured->featuredImage)
                    <img src="{{ Storage::url($featured->featuredImage->file_path) }}"
                         alt="{{ $featured->featuredImage->alt_text }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-nazareth-100">
                        <svg class="w-16 h-16 text-nazareth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <span class="absolute top-5 left-5 bg-nazareth-gold text-white text-[12px] font-semibold tracking-[.06em] uppercase px-3 py-1.5 rounded-full">
                    Destacado
                </span>
            </div>

            {{-- Info --}}
            <div class="flex flex-col justify-center px-10 py-12">
                <span class="inline-flex items-center gap-2 text-nazareth-700 font-semibold text-[14px] mb-3">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    {{ $featured->start_date->translatedFormat('l d \d\e F, Y') }}
                    @if($featured->end_date && $featured->end_date->ne($featured->start_date))
                        – {{ $featured->end_date->translatedFormat('d \d\e F') }}
                    @endif
                </span>

                <h3 class="font-display text-[28px] text-nazareth-ink leading-tight mb-3 tracking-tight">{{ $featured->title }}</h3>

                @if($featured->description)
                    <p class="text-[16px] text-[#4B5A5E] leading-relaxed mb-5">{{ Str::limit($featured->description, 200) }}</p>
                @endif

                <div class="flex flex-wrap gap-6 py-4 border-t border-b border-[#E3EAEB] mb-6 text-[14px] text-[#5A6A6E]">
                    @if($featured->location)
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-nazareth-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M17.66 16.66L13.41 20.9a1.99 1.99 0 01-2.82 0l-4.24-4.25a8 8 0 1111.31 0z"/><circle cx="12" cy="11" r="3"/>
                            </svg>
                            {{ $featured->location }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('website.events.show', $featured->slug) }}"
                       class="inline-flex items-center px-5 py-2.5 bg-nazareth-blue text-white text-[14px] font-semibold rounded-[10px] hover:bg-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
                        Ver detalles
                    </a>
                    <a href="{{ route('website.contact') }}"
                       class="inline-flex items-center px-5 py-2.5 border border-nazareth-blue text-nazareth-blue text-[14px] font-semibold rounded-[10px] hover:bg-nazareth-50 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2">
                        Contactar
                    </a>
                </div>
            </div>
        </article>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     PRÓXIMOS EVENTOS
     ══════════════════════════════════════════ --}}
@if($remaining->isNotEmpty())
<section class="pb-10">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex items-baseline justify-between mb-6 flex-wrap gap-3">
            <h2 class="font-display text-[26px] text-nazareth-blue tracking-tight">Próximos eventos</h2>
            <span class="text-[13px] font-semibold text-nazareth-700 bg-nazareth-50 px-3 py-1 rounded-full">
                {{ $remaining->count() }} {{ $remaining->count() === 1 ? 'evento programado' : 'eventos programados' }}
            </span>
        </div>

        <div class="space-y-3.5">
            @foreach($remaining as $event)
            <article class="grid items-center gap-7 bg-white border border-[#E3EAEB] rounded-[16px] px-7 py-6 hover:shadow-md transition-shadow"
                     style="grid-template-columns: 120px 1fr auto">
                {{-- Fecha badge --}}
                <div class="flex flex-col items-center bg-nazareth-50 border border-nazareth-100 rounded-[10px] px-2 py-3.5 text-center">
                    <span class="text-[11px] font-bold text-nazareth-700 uppercase tracking-[.12em]">{{ $event->start_date->translatedFormat('M') }}</span>
                    <span class="font-display text-[32px] font-semibold text-nazareth-blue leading-none my-1">{{ $event->start_date->format('d') }}</span>
                    <span class="text-[11px] text-[#9CA3AF]">{{ $event->start_date->format('Y') }}</span>
                </div>

                {{-- Cuerpo --}}
                <div>
                    <h3 class="text-[18px] font-semibold text-nazareth-ink mb-1.5 leading-snug">{{ $event->title }}</h3>
                    @if($event->description)
                        <p class="text-[14px] text-[#4B5A5E] leading-relaxed line-clamp-2">{{ $event->description }}</p>
                    @endif
                    <div class="flex flex-wrap gap-4 mt-2 text-[13px] text-[#9CA3AF]">
                        @if($event->location)
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M17.66 16.66L13.41 20.9a1.99 1.99 0 01-2.82 0l-4.24-4.25a8 8 0 1111.31 0z"/><circle cx="12" cy="11" r="3"/>
                                </svg>
                                {{ $event->location }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- CTA --}}
                <a href="{{ route('website.events.show', $event->slug) }}"
                   class="shrink-0 px-4 py-2 border border-nazareth-blue text-nazareth-blue text-[13px] font-semibold rounded-[8px] hover:bg-nazareth-50 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue whitespace-nowrap">
                    Detalles
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Sin eventos próximos --}}
@if($upcoming->isEmpty())
<section class="py-14">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="text-center py-16 bg-nazareth-50 rounded-[16px]">
            <svg class="w-14 h-14 text-nazareth-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-[#4B5A5E] text-lg">No hay eventos próximos en este momento.</p>
            <p class="text-[14px] text-[#9CA3AF] mt-1">Vuelve pronto para conocer nuestra agenda.</p>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     EVENTOS PASADOS
     ══════════════════════════════════════════ --}}
@if($past->isNotEmpty())
<section class="py-14 bg-nazareth-paper border-t border-[#E3EAEB] mt-4">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex items-baseline justify-between mb-8 flex-wrap gap-3">
            <h2 class="font-display text-[26px] text-nazareth-blue tracking-tight">Eventos pasados</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-[22px]">
            @foreach($past as $event)
            <article class="bg-white border border-[#E3EAEB] rounded-[16px] overflow-hidden flex flex-col hover:shadow-sm transition-shadow">
                {{-- Imagen --}}
                <div class="relative overflow-hidden bg-nazareth-100" style="aspect-ratio:16/10">
                    @if($event->featuredImage)
                        <img src="{{ Storage::url($event->featuredImage->file_path) }}"
                             alt="{{ $event->featuredImage->alt_text }}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-nazareth-100"></div>
                    @endif
                    <span class="absolute bottom-3 left-3 bg-white/95 text-nazareth-blue text-[12px] font-semibold px-2.5 py-1 rounded-[6px]">
                        {{ $event->start_date->translatedFormat('M Y') }}
                    </span>
                </div>

                {{-- Cuerpo --}}
                <div class="flex-1 flex flex-col px-5 py-[18px]">
                    <h3 class="text-[17px] font-semibold text-nazareth-ink mb-1.5 leading-snug">{{ $event->title }}</h3>
                    @if($event->description)
                        <p class="text-[13px] text-[#4B5A5E] leading-relaxed flex-1 mb-3">{{ Str::limit($event->description, 100) }}</p>
                    @else
                        <div class="flex-1"></div>
                    @endif
                    <a href="{{ route('website.events.show', $event->slug) }}"
                       class="text-[13px] font-semibold text-nazareth-700 hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                        Ver detalles →
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        @if($past->hasPages())
            <div class="mt-10">{{ $past->links() }}</div>
        @endif
    </div>
</section>
@endif

@endsection
