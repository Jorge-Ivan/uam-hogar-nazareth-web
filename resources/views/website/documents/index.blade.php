@extends('layouts.public')

@section('meta_title', 'Transparencia y documentos')
@section('meta_description', 'Accede a los documentos de transparencia institucional, registros DIAN e informes anuales de la Fundación Centro de Bienestar del Anciano Nazareth.')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "{{ url()->current() }}#webpage",
  "url": "{{ url()->current() }}",
  "name": "Transparencia y documentos · Fundación Centro de Bienestar del Anciano Nazareth",
  "description": "Documentos de transparencia institucional, registros DIAN e informes anuales.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "about": { "@id": "{{ url('/') }}/#organization" },
  "inLanguage": "es-CO"
}
</script>
@endpush

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
                    <span class="text-white font-medium" aria-current="page">Transparencia</span>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-medium text-white">
            Transparencia institucional
        </h1>
        <p class="text-white/80 mt-3 text-lg leading-relaxed max-w-2xl">
            Consulta nuestros documentos públicos, registros DIAN e informes anuales.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     BANDA DE TRANSPARENCIA
     ══════════════════════════════════════════ --}}
<div class="bg-nazareth-blue text-white py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center gap-4">
        <svg class="h-8 w-8 text-nazareth-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        <div>
            <p class="font-medium text-lg">Administración transparente de donaciones</p>
            <p class="text-white/80 text-sm mt-0.5">
                Accede a nuestros documentos institucionales, registros DIAN e informes anuales
            </p>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     DOCUMENTOS AGRUPADOS POR AÑO
     ══════════════════════════════════════════ --}}
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($documents->isEmpty())
            <div class="text-center py-16 bg-nazareth-gray rounded-xl">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 text-lg">No hay documentos disponibles en este momento.</p>
            </div>
        @else
            <div class="space-y-10">
                @foreach($documents as $year => $yearDocs)
                    <div>
                        {{-- Encabezado de año --}}
                        <h2 class="bg-nazareth-gray px-4 py-3 rounded-lg font-medium text-nazareth-blue text-lg mb-4">
                            {{ $year }}
                        </h2>

                        {{-- Lista de documentos del año --}}
                        <ul class="divide-y divide-gray-100" role="list">
                            @foreach($yearDocs as $document)
                                <li class="flex flex-col sm:flex-row sm:items-center gap-3 py-4">

                                    {{-- Ícono PDF --}}
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>

                                    {{-- Información del documento --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900">{{ $document->title }}</p>

                                        @if($document->category)
                                            <span class="inline-block mt-1 bg-nazareth-blue/10 text-nazareth-blue text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ $document->category->name }}
                                            </span>
                                        @endif

                                        @if($document->description)
                                            <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $document->description }}</p>
                                        @endif
                                    </div>

                                    {{-- Enlace de descarga --}}
                                    @if($document->media)
                                        <a href="{{ Storage::url($document->media->file_path) }}"
                                           download
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-2 flex-shrink-0 bg-nazareth-blue text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Descargar
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection
