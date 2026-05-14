@extends('layouts.public')

@section('meta_title', 'Un hogar cálido para nuestros mayores')
@section('meta_description', 'Acompañamos a adultos mayores de La Virginia y el occidente de Risaralda con cuidados integrales, actividades y el afecto de un verdadero hogar.')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "{{ url()->current() }}#webpage",
  "url": "{{ url()->current() }}",
  "name": "Un hogar cálido para nuestros mayores · Fundación Centro de Bienestar del Anciano Nazareth",
  "description": "Acompañamos a adultos mayores de La Virginia y el occidente de Risaralda con cuidados integrales, actividades y el afecto de un verdadero hogar.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "about": { "@id": "{{ url('/') }}/#organization" },
  "inLanguage": "es-CO"
}
</script>
@endpush

@push('styles')
<style>
/* Hero photo-led */
.home-hero {
    position: relative;
    padding: 120px 0;
    color: #fff;
    background: #1F2A2E;
    overflow: hidden;
}
.home-hero .hero-bg {
    position: absolute; inset: 0;
    background-image: url('https://images.unsplash.com/photo-1581579438747-104c53e7a77c?w=2000&q=80');
    background-size: cover; background-position: center;
    filter: saturate(.92);
}
.home-hero .hero-bg::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(
        105deg,
        rgba(10,107,115,.88) 0%,
        rgba(10,107,115,.72) 45%,
        rgba(10,107,115,.3)  80%,
        rgba(10,107,115,.15) 100%
    );
}

/* Testimonials radial decorations */
.testi-bg::before {
    content: ''; position: absolute; inset: 0;
    background:
        radial-gradient(circle at 15% 80%, rgba(255,255,255,.05), transparent 40%),
        radial-gradient(circle at 85% 20%, rgba(158,215,220,.08), transparent 50%);
    pointer-events: none;
}

/* CTA final radial decoration */
.cta-final-bg::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse at center, rgba(232,160,32,.15), transparent 60%);
}

/* Hero stats responsive */
@media (max-width: 640px) {
    .hero-stats { grid-template-columns: 1fr 1fr !important; gap: 20px !important; }
    .hero-stat-num { font-size: 32px !important; }
}

/* Event item responsive */
@media (max-width: 700px) {
    .event-item { grid-template-columns: 80px 1fr !important; }
    .event-item .event-btn { grid-column: 1 / -1; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
     ══════════════════════════════════════════ --}}
<section class="home-hero">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="relative z-10 max-w-[1200px] mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-10 lg:gap-16 items-center">

            {{-- Contenido textual --}}
            <div>
                {{-- Logo principal visible solo en mobile --}}
                <div class="flex justify-center mb-8 lg:hidden">
                    <div class="bg-white rounded-[16px] overflow-hidden shadow-[0_16px_40px_rgba(0,0,0,.22)]">
                        <img src="/images/logo_fundacion.png"
                             alt="Fundación Centro de Bienestar del Anciano Nazareth"
                             class="h-[90px] w-auto object-contain"
                             height="90"
                             loading="eager">
                    </div>
                </div>

                <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-white/85 mb-3.5">
                    Fundación Centro de Bienestar del Anciano Nazareth · desde 1985
                </span>
                <h1 class="font-display text-[clamp(40px,5.6vw,64px)] leading-[1.05] text-white mb-5 max-w-[18ch] tracking-tight">
                    Un hogar donde los años se viven con <em class="not-italic text-nazareth-gold font-medium">cariño</em>.
                </h1>
                <p class="text-[19px] text-white/90 max-w-[52ch] mb-8 leading-relaxed">
                    Acompañamos a adultos mayores de La Virginia y el occidente de Risaralda con cuidados integrales, actividades que mantienen el ánimo en alto y el afecto de un verdadero hogar.
                </p>
                <div class="flex gap-3.5 flex-wrap">
                    <a href="{{ route('website.donations') }}"
                       class="inline-flex items-center gap-2 px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-nazareth-gold text-white hover:bg-amber-600 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue">
                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        Quiero apoyar
                    </a>
                    <a href="{{ route('website.activities.index') }}"
                       class="inline-flex items-center gap-2 px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-transparent text-white border-2 border-white/70 hover:bg-white/10 hover:border-white transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-nazareth-blue">
                        Conoce la fundación
                    </a>
                </div>

                <div class="hero-stats grid grid-cols-3 gap-8 mt-12 pt-10 border-t border-white/20 max-w-[640px]">
                    <div>
                        <strong class="hero-stat-num block font-display text-[40px] font-semibold text-white leading-none">{{ now()->year - 1985 }}</strong>
                        <span class="text-[13px] text-white/[.78]">años cuidando</span>
                    </div>
                    <div>
                        <strong class="hero-stat-num block font-display text-[40px] font-semibold text-white leading-none">50</strong>
                        <span class="text-[13px] text-white/[.78]">adultos mayores atendidos</span>
                    </div>
                    <div>
                        <strong class="hero-stat-num block font-display text-[40px] font-semibold text-white leading-none">100%</strong>
                        <span class="text-[13px] text-white/[.78]">sin fines de lucro</span>
                    </div>
                </div>
            </div>

            {{-- Isotipo desktop --}}
            <div class="hidden lg:flex items-center justify-center">
                <div class="bg-white rounded-[24px] p-10 shadow-[0_32px_80px_rgba(0,0,0,.28)]">
                    <img src="{{ asset('images/logo_fundacion_isotipo-2.png') }}"
                         alt="Fundación Centro de Bienestar del Anciano Nazareth"
                         class="w-[200px] h-[200px] object-contain"
                         width="200" height="200"
                         loading="eager">
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     MISIÓN
     ══════════════════════════════════════════ --}}
<section class="py-24 bg-nazareth-paper">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

            <div class="relative rounded-[20px] overflow-hidden aspect-[5/4]">
                <img src="{{ asset('images/home/foto-grupo.jpeg') }}"
                     alt="Foto Grupal de adultos mayores compartiendo en el hogar"
                     class="w-full h-full object-cover"
                     loading="lazy">
            </div>

            <div>
                <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Quiénes somos</span>
                <h2 class="font-display text-[clamp(32px,3.5vw,42px)] text-nazareth-ink mb-4 leading-[1.15] tracking-tight">
                    Creemos que la vejez merece ser vivida con calma, compañía y propósito.
                </h2>
                <p class="text-[18px] text-[#4B5A5E] leading-[1.6] mb-6 max-w-[62ch]">
                    Desde 1985 recibimos a adultos mayores en situación de vulnerabilidad de La Virginia. Aquí no son residentes, son familia. Cuatro valores guían cada decisión y cada acción.
                </p>
                <div class="grid grid-cols-2 gap-x-8 gap-y-5 mt-8 pt-7 border-t border-[#E3EAEB]">
                    <div>
                        <strong class="block text-nazareth-blue font-semibold text-[15px] mb-1">Calidad humana</strong>
                        <span class="text-[14px] text-[#4B5A5E]">Tratar a cada persona con respeto a su dignidad, atención a sus necesidades y apoyo a su desarrollo personal.</span>
                    </div>
                    <div>
                        <strong class="block text-nazareth-blue font-semibold text-[15px] mb-1">Responsabilidad social</strong>
                        <span class="text-[14px] text-[#4B5A5E]">Cada acción busca tener un impacto positivo en la comunidad, afirmando los principios que guían nuestra labor.</span>
                    </div>
                    <div>
                        <strong class="block text-nazareth-blue font-semibold text-[15px] mb-1">Solidaridad</strong>
                        <span class="text-[14px] text-[#4B5A5E]">Apoyar a quien lo necesita de manera desinteresada, por empatía y reconocimiento del otro, sin esperar nada a cambio.</span>
                    </div>
                    <div>
                        <strong class="block text-nazareth-blue font-semibold text-[15px] mb-1">Honestidad</strong>
                        <span class="text-[14px] text-[#4B5A5E]">Pensar, decir y actuar de manera coherente, con respeto al prójimo como fundamento de nuestra convivencia.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     ACTIVIDADES
     ══════════════════════════════════════════ --}}
<section class="py-20 bg-white">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="text-center max-w-[56ch] mx-auto mb-12">
            <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Actividades</span>
            <h2 class="font-display text-[clamp(28px,3.2vw,40px)] text-nazareth-ink mb-3 tracking-tight">Un día en el hogar no se parece al anterior</h2>
            <p class="text-[17px] text-[#4B5A5E]">Terapias, celebraciones, salidas y momentos de fe que mantienen el cuerpo y el alma en movimiento.</p>
        </div>

        @if($activities->isEmpty())
            <div class="text-center py-16 bg-nazareth-50 rounded-[14px] border border-[#E3EAEB]">
                <p class="text-[#5A6A6E] text-[17px]">Próximamente compartiremos nuestras actividades.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activities as $activity)
                <article class="group bg-white border border-[#E3EAEB] rounded-[14px] overflow-hidden transition-all duration-200 hover:border-nazareth-200 hover:shadow-md hover:-translate-y-0.5">

                    {{-- Imagen --}}
                    <a href="{{ route('website.activities.show', $activity->slug) }}" class="block overflow-hidden aspect-video" tabindex="-1" aria-hidden="true">
                        @if($activity->featuredImage)
                            <img src="{{ Storage::url($activity->featuredImage->file_path) }}"
                                 alt="{{ $activity->featuredImage->alt_text }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-nazareth-50 flex items-center justify-center">
                                <svg class="w-12 h-12 text-nazareth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </a>

                    {{-- Cuerpo --}}
                    <div class="p-7">
                        @if($activity->published_at)
                            <span class="block text-[12px] text-[#5A6A6E] mb-2">
                                {{ $activity->published_at->translatedFormat('d \d\e F, Y') }}
                            </span>
                        @endif
                        <h3 class="text-[19px] font-semibold text-nazareth-ink mb-2 leading-snug">
                            {{ $activity->title }}
                        </h3>
                        @if($activity->excerpt)
                            <p class="text-[14px] text-[#4B5A5E] mb-0 line-clamp-2">{{ $activity->excerpt }}</p>
                        @endif
                        <a href="{{ route('website.activities.show', $activity->slug) }}"
                           class="inline-flex items-center gap-1 mt-4 text-nazareth-700 text-[14px] font-semibold hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                            Leer más →
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        @endif

        <div class="mt-10 text-center">
            <a href="{{ route('website.activities.index') }}"
               class="inline-flex items-center gap-2 text-nazareth-700 text-[15px] font-semibold hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                Ver todas las actividades →
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     TESTIMONIOS — oculto hasta tener testimonios reales
     ══════════════════════════════════════════ --}}
@if (false)
<section class="testi-bg relative py-20 bg-nazareth-blue overflow-hidden">
    <div class="relative z-10 max-w-[1200px] mx-auto px-6">
        <div class="text-center max-w-[56ch] mx-auto mb-12">
            <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-gold mb-3.5">Voces del hogar</span>
            <h2 class="font-display text-[clamp(28px,3.2vw,40px)] text-white tracking-tight">Las familias cuentan mejor lo que hacemos</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
            $testimonials = [
                [
                    'quote' => 'Mi mamá llegó triste, apagada. Hoy canta en las tardes y nos cuenta con orgullo los amigos que tiene. El Hogar le devolvió las ganas.',
                    'name'  => 'Luz Marina Cardona',
                    'role'  => 'Hija de Doña Blanca · Pereira',
                    'img'   => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&q=80',
                ],
                [
                    'quote' => 'Los muchachos de la universidad nos visitan cada mes y ahora nos sabemos los nombres. Se siente uno menos solo, que lo tengan a uno en cuenta.',
                    'name'  => 'Don Hernando Ríos',
                    'role'  => 'Residente desde 2019',
                    'img'   => 'https://images.unsplash.com/photo-1581579438747-104c53e7a77c?w=200&q=80',
                ],
                [
                    'quote' => 'Vine un sábado a pintar con ellos y no paré. Es otro ritmo, otra forma de entender la vida. Volver se vuelve costumbre.',
                    'name'  => 'Isabela Montoya',
                    'role'  => 'Voluntaria · estudiante de psicología',
                    'img'   => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80',
                ],
            ];
            @endphp

            @foreach($testimonials as $testi)
            <article class="bg-white/[.06] border border-white/[.12] rounded-[14px] p-7 backdrop-blur-sm">
                <p class="font-display text-[18px] leading-[1.55] text-white mb-5 italic font-medium">
                    <span class="not-italic text-nazareth-gold text-[40px] leading-none align-[-12px] mr-1 font-bold">"</span>{{ $testi['quote'] }}
                </p>
                <div class="flex items-center gap-3 pt-4 border-t border-white/[.12]">
                    <img src="{{ $testi['img'] }}"
                         alt="{{ $testi['name'] }}"
                         class="w-11 h-11 rounded-full object-cover bg-nazareth-200"
                         loading="lazy">
                    <div>
                        <strong class="block text-[14px] font-semibold text-white">{{ $testi['name'] }}</strong>
                        <span class="block text-[12px] text-white/65">{{ $testi['role'] }}</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     PRÓXIMOS EVENTOS
     ══════════════════════════════════════════ --}}
<section class="py-20 bg-nazareth-paper">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex justify-between items-end gap-6 flex-wrap mb-8">
            <div>
                <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Agenda</span>
                <h2 class="font-display text-[clamp(28px,3.2vw,40px)] text-nazareth-ink tracking-tight m-0">Eventos en curso y próximos</h2>
            </div>
            <a href="{{ route('website.events.index') }}"
               class="inline-flex items-center gap-2 px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-transparent text-nazareth-blue border-2 border-nazareth-200 hover:bg-nazareth-50 hover:border-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue">
                Ver todos los eventos →
            </a>
        </div>

        @if($events->isEmpty())
            <p class="text-[#5A6A6E] py-8 text-center">No hay eventos próximos por el momento.</p>
        @else
            <div class="space-y-4">
                @foreach($events as $event)
                @php
                    $isOngoing = $event->start_date->isPast()
                        && ($event->end_date === null || $event->end_date->isFuture());
                @endphp
                <article class="event-item grid items-center bg-white border rounded-[14px] p-6 transition-shadow duration-150 hover:shadow-md {{ $isOngoing ? 'border-nazareth-light' : 'border-[#E3EAEB]' }}"
                         style="grid-template-columns: 120px 1fr auto; gap: 28px;">
                    {{-- Fecha --}}
                    <div class="flex flex-col items-center {{ $isOngoing ? 'bg-nazareth-blue border-nazareth-blue' : 'bg-nazareth-50 border-nazareth-100' }} border rounded-[10px] py-3.5 px-2 text-center">
                        <span class="text-[12px] font-bold {{ $isOngoing ? 'text-white/80' : 'text-nazareth-700' }} uppercase tracking-[.12em]">
                            {{ $event->start_date->translatedFormat('M') }}
                        </span>
                        <span class="font-display text-[32px] font-semibold {{ $isOngoing ? 'text-white' : 'text-nazareth-blue' }} leading-none my-1">
                            {{ $event->start_date->format('d') }}
                        </span>
                        <span class="text-[11px] {{ $isOngoing ? 'text-white/70' : 'text-[#5A6A6E]' }}">{{ $event->start_date->format('Y') }}</span>
                    </div>

                    {{-- Info --}}
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <h3 class="text-[18px] font-semibold text-nazareth-ink m-0">{{ $event->title }}</h3>
                            @if($isOngoing)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-nazareth-green/10 text-nazareth-green whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-nazareth-green"></span>
                                    En curso
                                </span>
                            @endif
                        </div>
                        @if($event->description)
                            <p class="text-[14px] text-[#4B5A5E] mb-0 line-clamp-2">{{ $event->description }}</p>
                        @endif
                        <div class="flex gap-4 mt-2">
                            @if($event->location)
                            <span class="inline-flex items-center gap-1 text-[13px] text-[#5A6A6E]">
                                <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M17.66 16.66L13.41 20.9a1.99 1.99 0 01-2.82 0l-4.24-4.25a8 8 0 1111.31 0z"/><circle cx="12" cy="11" r="3"/>
                                </svg>
                                {{ $event->location }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Acción --}}
                    <a href="{{ route('website.events.show', $event->slug) }}"
                       class="event-btn inline-flex items-center gap-2 px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-transparent text-nazareth-blue border-2 border-nazareth-200 hover:bg-nazareth-50 hover:border-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue whitespace-nowrap">
                        Detalles
                    </a>
                </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════
     CÓMO APOYAR
     ══════════════════════════════════════════ --}}
<section class="py-24 bg-white" id="apoyar">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="text-center max-w-[56ch] mx-auto mb-12">
            <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-gold mb-3.5">Cómo apoyar</span>
            <h2 class="font-display text-[clamp(28px,3.2vw,40px)] text-nazareth-ink mb-3 tracking-tight">Tres formas concretas de ser parte del hogar</h2>
            <p class="text-[17px] text-[#4B5A5E]">Cualquier cantidad suma. Cualquier hora que regales, suma. Cualquier palabra de aliento, suma.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="p-9 bg-white border border-[#E3EAEB] rounded-[20px] transition-all duration-200 hover:border-nazareth-light hover:shadow-[0_20px_50px_-20px_rgba(10,107,115,.25)] hover:-translate-y-1">
                <div class="font-display text-[48px] font-semibold text-nazareth-200 leading-none mb-3">01</div>
                <h3 class="text-[22px] font-semibold text-nazareth-blue mb-2.5">Donación directa</h3>
                <p class="text-[15px] text-[#4B5A5E] mb-5">Cualquier aporte, por pequeño que sea, se convierte en comida, cuidado y compañía para quienes más lo necesitan.</p>
                <a href="{{ route('website.donations') }}"
                   class="w-full inline-flex items-center justify-center px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-nazareth-blue text-white hover:bg-nazareth-700 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue">
                    Donar ahora
                </a>
            </article>

            <article class="p-9 bg-gradient-to-b from-nazareth-50 to-white border border-nazareth-200 rounded-[20px] transition-all duration-200 hover:border-nazareth-light hover:shadow-[0_20px_50px_-20px_rgba(10,107,115,.25)] hover:-translate-y-1">
                <div class="font-display text-[48px] font-semibold text-nazareth-gold leading-none mb-3">02</div>
                <h3 class="text-[22px] font-semibold text-nazareth-blue mb-2.5">Apadrina un adulto mayor</h3>
                <p class="text-[15px] text-[#4B5A5E] mb-5">Acompañamiento mensual a una persona específica. Reporte trimestral con su evolución, fotos y una carta escrita por él o ella.</p>
                <a href="{{ route('website.contact') }}"
                   class="w-full inline-flex items-center justify-center px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-nazareth-gold text-white hover:bg-amber-600 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold">
                    Apadrinar
                </a>
            </article>

            <article class="p-9 bg-white border border-[#E3EAEB] rounded-[20px] transition-all duration-200 hover:border-nazareth-light hover:shadow-[0_20px_50px_-20px_rgba(10,107,115,.25)] hover:-translate-y-1">
                <div class="font-display text-[48px] font-semibold text-nazareth-200 leading-none mb-3">03</div>
                <h3 class="text-[22px] font-semibold text-nazareth-blue mb-2.5">Voluntariado</h3>
                <p class="text-[15px] text-[#4B5A5E] mb-5">Regala una tarde. Jugar parqués, peinar, leer el periódico, enseñar una canción. Nos organizamos según tu disponibilidad.</p>
                <a href="{{ route('website.contact') }}"
                   class="w-full inline-flex items-center justify-center px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-nazareth-blue text-white hover:bg-nazareth-700 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue">
                    Quiero ayudar
                </a>
            </article>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     TRANSPARENCIA
     ══════════════════════════════════════════ --}}
<section class="py-[72px] bg-nazareth-50 border-t border-b border-nazareth-100">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-[1.2fr_1fr] gap-12 items-center">
            <div>
                <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Transparencia</span>
                <h2 class="font-display text-[clamp(28px,3.2vw,40px)] text-nazareth-blue mb-3 tracking-tight">Cuentas claras, siempre</h2>
                <p class="text-[18px] text-[#4B5A5E] leading-[1.6] mb-6 max-w-[62ch]">
                    Somos una entidad sin ánimo de lucro registrada ante la DIAN como Entidad del Régimen Tributario Especial. Publicamos cada año los estados financieros y el destino de cada peso donado.
                </p>
                <a href="{{ route('website.documents.index') }}"
                   class="inline-flex items-center gap-2 px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-transparent text-nazareth-blue border-2 border-nazareth-200 hover:bg-white hover:border-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-blue">
                    Ver documentos y reportes →
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white border border-nazareth-100 rounded-[14px] p-5">
                    <strong class="block font-display text-[28px] font-semibold text-nazareth-blue leading-[1.1] mb-1">{{ $documentCount }}</strong>
                    <span class="text-[13px] text-[#4B5A5E]">Reportes anuales públicos</span>
                </div>
                <div class="bg-white border border-nazareth-100 rounded-[14px] p-5">
                    <strong class="block font-display text-[28px] font-semibold text-nazareth-blue leading-[1.1] mb-1">NIT</strong>
                    <span class="text-[13px] text-[#4B5A5E]">{{ $siteSettings->org_nit ?? '891.401.XXX-X' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CTA FINAL
     ══════════════════════════════════════════ --}}
<section class="cta-final-bg relative py-[100px] bg-nazareth-ink text-white text-center overflow-hidden">
    <div class="relative z-10 max-w-[1200px] mx-auto px-6">
        <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-gold mb-3.5">Hazte parte</span>
        <h2 class="font-display text-[clamp(32px,4vw,48px)] text-white max-w-[20ch] mx-auto mb-4 tracking-tight">Un hogar se construye entre todos</h2>
        <p class="text-[18px] text-white/80 max-w-[52ch] mx-auto mb-8">Donación, voluntariado o sólo compartir. Escríbenos y encontramos la mejor forma de que aportes lo que quieras aportar.</p>
        <div class="flex gap-3.5 justify-center flex-wrap">
            <a href="{{ route('website.donations') }}"
               class="inline-flex items-center gap-2 px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-nazareth-gold text-white hover:bg-amber-600 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-ink">
                Quiero donar
            </a>
            <a href="{{ route('website.contact') }}"
               class="inline-flex items-center gap-2 px-[22px] py-3 rounded-[10px] text-[15px] font-semibold bg-transparent text-white border-2 border-white/70 hover:bg-white/10 hover:border-white transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-nazareth-ink">
                Escríbenos
            </a>
        </div>
    </div>
</section>

@endsection
