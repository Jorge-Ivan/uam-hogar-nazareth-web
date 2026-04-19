@extends('layouts.public')

@section('meta_title', 'Donaciones')
@section('meta_description', 'Apoya a la Fundación Hogar del Anciano Nazareth con tu donación. Conoce cómo contribuir a nuestra misión.')

@section('content')

{{-- ══════════════════════════════════════════
     ENCABEZADO DE SECCIÓN
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-r from-nazareth-blue to-nazareth-light py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <span class="text-white font-medium" aria-current="page">Donaciones</span>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-medium text-white">
            Apoya nuestra misión
        </h1>
        <p class="text-white/80 mt-3 text-lg leading-relaxed max-w-2xl">
            Tu contribución hace posible que sigamos brindando cuidado, acompañamiento y dignidad
            a nuestros adultos mayores.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CONTENIDO DE DONACIONES
     ══════════════════════════════════════════ --}}
<section class="bg-nazareth-gray py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
            $hasBankInfo = $siteSettings->donation_bank_name || $siteSettings->donation_account;
            $hasNequi    = (bool) $siteSettings->donation_nequi;
            $hasDaviplata = (bool) $siteSettings->donation_daviplata;
            $hasAnyDigital = $hasBankInfo || $hasNequi || $hasDaviplata;
        @endphp

        @if(! $hasAnyDigital)
            {{-- Fallback --}}
            <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <p class="text-gray-600 text-lg font-medium mb-2">
                    Para información sobre donaciones, contáctenos directamente
                </p>
                <p class="text-gray-500 text-sm mb-6">
                    Estaremos encantados de orientarle sobre cómo puede apoyar nuestra misión.
                </p>
                <a href="{{ route('website.contact') }}"
                   class="inline-flex items-center bg-nazareth-gold text-white font-medium px-6 py-3 rounded-lg hover:bg-yellow-500 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2">
                    Contáctenos
                </a>
            </div>
        @else
            <div class="space-y-6">

                {{-- SECCIÓN 1: Transferencia bancaria --}}
                @if($hasBankInfo)
                <div class="bg-nazareth-blue text-white rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <svg class="h-7 w-7 text-nazareth-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 6l9-3 9 3M3 6v12l9 3 9-3V6M3 6l9 3 9-3"/>
                        </svg>
                        <h2 class="text-xl font-medium">Transferencia bancaria</h2>
                    </div>

                    <dl class="space-y-3">
                        @if($siteSettings->donation_bank_name)
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <dt class="text-white/70 text-sm sm:w-36 flex-shrink-0">Banco</dt>
                                <dd class="font-medium">{{ $siteSettings->donation_bank_name }}</dd>
                            </div>
                        @endif

                        @if($siteSettings->donation_account_type)
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <dt class="text-white/70 text-sm sm:w-36 flex-shrink-0">Tipo de cuenta</dt>
                                <dd class="font-medium">{{ $siteSettings->donation_account_type }}</dd>
                            </div>
                        @endif

                        @if($siteSettings->donation_account)
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <dt class="text-white/70 text-sm sm:w-36 flex-shrink-0">Número de cuenta</dt>
                                <dd class="font-medium">{{ $siteSettings->donation_account }}</dd>
                            </div>
                        @endif

                        @if($siteSettings->donation_nit_bank)
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <dt class="text-white/70 text-sm sm:w-36 flex-shrink-0">NIT</dt>
                                <dd class="font-medium">{{ $siteSettings->donation_nit_bank }}</dd>
                            </div>
                        @endif

                        @if($siteSettings->donation_account_holder)
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <dt class="text-white/70 text-sm sm:w-36 flex-shrink-0">Titular</dt>
                                <dd class="font-medium">{{ $siteSettings->donation_account_holder }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
                @endif

                {{-- SECCIÓN 2: Nequi --}}
                @if($hasNequi)
                <div class="bg-[#6c2bb5] text-white rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <svg class="h-7 w-7 text-pink-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <h2 class="text-xl font-medium">Nequi</h2>
                    </div>

                    <p class="text-2xl font-medium tracking-wide">{{ $siteSettings->donation_nequi }}</p>

                    @if($siteSettings->donationQr)
                        <div class="mt-5 flex justify-center">
                            <img src="{{ Storage::url($siteSettings->donationQr->file_path) }}"
                                 alt="Código QR Nequi"
                                 class="w-48 h-48 object-contain rounded-lg bg-white p-2"
                                 loading="lazy">
                        </div>
                        <p class="text-center text-white/70 text-sm mt-2">Escanea el código QR con tu app de Nequi</p>
                    @endif
                </div>
                @endif

                {{-- SECCIÓN 3: Daviplata --}}
                @if($hasDaviplata)
                <div class="bg-[#e30019] text-white rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <svg class="h-7 w-7 text-orange-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <h2 class="text-xl font-medium">Daviplata</h2>
                    </div>

                    <p class="text-2xl font-medium tracking-wide">{{ $siteSettings->donation_daviplata }}</p>
                    <p class="text-white/70 text-sm mt-2">Envía tu donación al número de celular indicado</p>
                </div>
                @endif

                {{-- SECCIÓN 4: Donación en especie (siempre visible) --}}
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="h-7 w-7 text-nazareth-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <h2 class="text-xl font-medium text-gray-900">Donación en especie</h2>
                    </div>

                    <p class="text-gray-600 leading-relaxed">
                        También puedes apoyarnos con alimentos, ropa, medicamentos, materiales de aseo
                        o cualquier otro artículo que contribuya al bienestar de nuestros residentes.
                    </p>

                    <a href="{{ route('website.contact') }}"
                       class="inline-flex items-center mt-4 text-nazareth-blue hover:text-nazareth-light font-medium transition-colors focus:outline-none focus:underline">
                        Contáctenos para coordinar la entrega
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
        @endif

    </div>
</section>

@endsection
