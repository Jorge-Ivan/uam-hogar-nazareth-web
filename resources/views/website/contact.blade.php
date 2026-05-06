@extends('layouts.public')

@section('meta_title', 'Contacto')
@section('meta_description', 'Contáctanos para consultas sobre donaciones, voluntariado, visitas o información sobre el ingreso de un familiar.')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "@id": "{{ url()->current() }}#webpage",
  "url": "{{ url()->current() }}",
  "name": "Contacto · Hogar Nazareth",
  "description": "Consultas sobre donaciones, voluntariado, visitas o información sobre el ingreso de un familiar.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "inLanguage": "es-CO"
}
</script>
@endpush

@push('styles')
<style>
/* Map placeholder stripes */
.map-placeholder {
    background: repeating-linear-gradient(
        45deg,
        #EAF4F5,
        #EAF4F5 20px,
        #fff 20px,
        #fff 40px
    );
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-b from-nazareth-50 to-white pt-[72px] pb-12 border-b border-nazareth-100">
    <div class="max-w-[1200px] mx-auto px-6">
        <span class="inline-block text-xs font-semibold tracking-[.14em] uppercase text-nazareth-700 mb-3.5">Escríbenos</span>
        <h1 class="font-display text-[clamp(36px,4.5vw,48px)] text-nazareth-blue leading-tight mb-4 tracking-tight">
            Estamos aquí para conversar
        </h1>
        <p class="text-[18px] text-[#4B5A5E] max-w-[58ch] leading-relaxed">
            Para consultas sobre donaciones, voluntariado, visitas o información sobre cómo ingresar a un familiar.  Te respondemos lo más pronto posible.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CONTENIDO PRINCIPAL
     ══════════════════════════════════════════ --}}
<section class="py-20">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-[1.2fr_1fr] gap-14">

            {{-- ── FORMULARIO (izquierda) ── --}}
            <div class="bg-white border border-[#E3EAEB] rounded-[20px] p-10">
                <h2 class="font-display text-[26px] text-nazareth-ink mb-2 tracking-tight">Envíanos un mensaje</h2>
                <p class="text-[15px] text-[#4B5A5E] mb-7">Cuéntanos en qué podemos ayudarte y te contactamos pronto.</p>

                @if($siteSettings->mail_contact_to)
                    <livewire:website.contact-form />
                @else
                    <div class="text-center py-10">
                        <svg class="w-12 h-12 text-nazareth-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-[#4B5A5E]">El formulario no está disponible en este momento.</p>
                        <p class="text-[14px] text-[#5A6A6E] mt-1">Usa nuestros datos de contacto directos.</p>
                    </div>
                @endif
            </div>

            {{-- ── DATOS DE CONTACTO (derecha) ── --}}
            <div>
                <h2 class="font-display text-[24px] text-nazareth-blue mb-5 tracking-tight">Datos de contacto</h2>
                <p class="text-[15px] text-[#4B5A5E] mb-6">Puedes escribirnos, llamarnos o visitarnos. Estamos disponibles de lunes a sábado.</p>

                <div class="divide-y divide-[#E3EAEB]">

                    @if($siteSettings->contact_address)
                    <div class="flex gap-4 items-start py-[18px]">
                        <div class="w-11 h-11 bg-nazareth-50 rounded-[10px] flex items-center justify-center text-nazareth-blue shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M17.66 16.66L13.41 20.9a1.99 1.99 0 01-2.82 0l-4.24-4.25a8 8 0 1111.31 0z"/><circle cx="12" cy="11" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="block text-[15px] font-semibold text-nazareth-ink mb-1">Dirección</strong>
                            <span class="text-[14px] text-[#4B5A5E]">{{ $siteSettings->contact_address }}</span>
                        </div>
                    </div>
                    @endif

                    @if($siteSettings->contact_phone)
                    <div class="flex gap-4 items-start py-[18px]">
                        <div class="w-11 h-11 bg-nazareth-50 rounded-[10px] flex items-center justify-center text-nazareth-blue shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="block text-[15px] font-semibold text-nazareth-ink mb-1">Teléfono</strong>
                            <a href="tel:{{ $siteSettings->contact_phone }}"
                               class="text-[14px] text-[#4B5A5E] hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                                {{ $siteSettings->contact_phone }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($siteSettings->contact_whatsapp)
                    <div class="flex gap-4 items-start py-[18px]">
                        <div class="w-11 h-11 bg-nazareth-50 rounded-[10px] flex items-center justify-center text-nazareth-blue shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="block text-[15px] font-semibold text-nazareth-ink mb-1">WhatsApp</strong>
                            <a href="https://wa.me/{{ $siteSettings->contact_whatsapp }}"
                               target="_blank" rel="noopener noreferrer"
                               class="text-[14px] text-[#4B5A5E] hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                                +{{ $siteSettings->contact_whatsapp }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($siteSettings->contact_email)
                    <div class="flex gap-4 items-start py-[18px]">
                        <div class="w-11 h-11 bg-nazareth-50 rounded-[10px] flex items-center justify-center text-nazareth-blue shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="block text-[15px] font-semibold text-nazareth-ink mb-1">Correo electrónico</strong>
                            <a href="mailto:{{ $siteSettings->contact_email }}"
                               class="text-[14px] text-[#4B5A5E] hover:text-nazareth-blue transition-colors focus:outline-none focus:underline break-all">
                                {{ $siteSettings->contact_email }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($siteSettings->contact_schedule)
                    <div class="flex gap-4 items-start py-[18px]">
                        <div class="w-11 h-11 bg-nazareth-50 rounded-[10px] flex items-center justify-center text-nazareth-blue shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="block text-[15px] font-semibold text-nazareth-ink mb-1">Horario de atención</strong>
                            <span class="text-[14px] text-[#4B5A5E]">{{ $siteSettings->contact_schedule }}</span>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Mapa --}}
                <div class="mt-7 aspect-[3/2] rounded-[14px] overflow-hidden border border-[#E3EAEB] relative">
                    @if(isset($siteSettings->contact_maps_url) && $siteSettings->contact_maps_url)
                        <iframe
                            src="{{ $siteSettings->contact_maps_url }}"
                            width="100%" height="100%"
                            style="border:0; position:absolute; inset:0;"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Ubicación de la Fundación Hogar del Anciano Nazareth"
                        ></iframe>
                    @else
                        <div class="map-placeholder absolute inset-0 flex flex-col items-center justify-center gap-2 text-nazareth-blue">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path d="M17.66 16.66L13.41 20.9a1.99 1.99 0 01-2.82 0l-4.24-4.25a8 8 0 1111.31 0z"/><circle cx="12" cy="11" r="3"/>
                            </svg>
                            <strong class="text-[15px] font-semibold">Mapa de ubicación</strong>
                            <span class="text-[13px] text-[#5A6A6E]">La Virginia, Risaralda · Colombia</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
