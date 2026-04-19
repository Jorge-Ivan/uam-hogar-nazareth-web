@extends('layouts.public')

@section('meta_title', 'Contacto')
@section('meta_description', 'Ponte en contacto con la Fundación Hogar del Anciano Nazareth. Estamos aquí para atenderte.')

@section('content')

{{-- ══════════════════════════════════════════
     ENCABEZADO DE SECCIÓN
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-r from-nazareth-blue to-nazareth-light py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav aria-label="Ruta de navegación" class="mb-4">
            <ol class="flex items-center gap-2 text-sm text-white/70">
                <li>
                    <a href="{{ route('website.home') }}"
                       class="hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                        Inicio
                    </a>
                </li>
                <li aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>
                    <span class="text-white font-medium" aria-current="page">Contacto</span>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-medium text-white">
            Contáctanos
        </h1>
        <p class="text-white/80 mt-3 text-lg leading-relaxed max-w-2xl">
            Estamos aquí para atenderte. No dudes en comunicarte con nosotros.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CONTENIDO PRINCIPAL — DOS COLUMNAS
     ══════════════════════════════════════════ --}}
<section class="bg-nazareth-gray py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

            {{-- ───────────────────────────────
                 COLUMNA IZQUIERDA — Info de contacto
                 ─────────────────────────────── --}}
            <div>
                <h2 class="text-xl font-medium text-nazareth-blue mb-6">Información de contacto</h2>

                <div class="space-y-5">

                    {{-- Dirección --}}
                    @if($siteSettings->contact_address)
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-nazareth-blue mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Dirección</p>
                                <p class="text-gray-700 leading-relaxed">{{ $siteSettings->contact_address }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Teléfono --}}
                    @if($siteSettings->contact_phone)
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-nazareth-blue mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Teléfono</p>
                                <a href="tel:{{ $siteSettings->contact_phone }}"
                                   class="text-gray-700 hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                                    {{ $siteSettings->contact_phone }}
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- WhatsApp --}}
                    @if($siteSettings->contact_whatsapp)
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">WhatsApp</p>
                                <a href="https://wa.me/{{ $siteSettings->contact_whatsapp }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="text-gray-700 hover:text-green-600 transition-colors focus:outline-none focus:underline">
                                    {{ $siteSettings->contact_whatsapp }}
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Correo electrónico --}}
                    @if($siteSettings->contact_email)
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-nazareth-blue mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Correo electrónico</p>
                                <a href="mailto:{{ $siteSettings->contact_email }}"
                                   class="text-gray-700 hover:text-nazareth-blue transition-colors focus:outline-none focus:underline">
                                    {{ $siteSettings->contact_email }}
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Horario de atención --}}
                    @if($siteSettings->contact_schedule)
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-nazareth-blue mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-0.5">Horario de atención</p>
                                <p class="text-gray-700">{{ $siteSettings->contact_schedule }}</p>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Mapa de Google --}}
                @if($siteSettings->contact_maps_url)
                    <div class="mt-6">
                        <iframe
                            src="{{ $siteSettings->contact_maps_url }}"
                            width="100%"
                            height="300"
                            style="border:0;"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="rounded-xl shadow-sm"
                            title="Ubicación de la Fundación Hogar del Anciano Nazareth"
                        ></iframe>
                    </div>
                @endif
            </div>

            {{-- ───────────────────────────────
                 COLUMNA DERECHA — Formulario de contacto
                 ─────────────────────────────── --}}
            <div>
                <h2 class="text-xl font-medium text-nazareth-blue mb-6">Envíanos un mensaje</h2>

                @if($siteSettings->mail_contact_to)
                    <livewire:website.contact-form />
                @else
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-600">El formulario de contacto no está disponible en este momento.</p>
                        <p class="text-sm text-gray-500 mt-2">Por favor, utilice nuestros datos de contacto directos.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection
