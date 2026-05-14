@extends('layouts.public')

@section('meta_title', $page->title)
@section('meta_description', Str::limit(strip_tags($page->content), 160))

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "{{ url()->current() }}#webpage",
  "url": "{{ url()->current() }}",
  "name": "{{ $page->title }} · Fundación Centro de Bienestar del Anciano Nazareth",
  "description": "{{ Str::limit(strip_tags($page->content), 160) }}",
  "datePublished": "{{ $page->published_at?->toIso8601String() ?? $page->created_at->toIso8601String() }}",
  "dateModified": "{{ $page->updated_at->toIso8601String() }}",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "about": { "@id": "{{ url('/') }}/#organization" },
  "inLanguage": "es-CO"
}
</script>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     ENCABEZADO / BREADCRUMB
     ══════════════════════════════════════════ --}}
<section class="bg-gradient-to-r from-nazareth-blue to-nazareth-light py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav aria-label="Ruta de navegación" class="mb-4">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-white/70">
                <li>
                    <a href="{{ route('website.home') }}"
                       class="hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                        Inicio
                    </a>
                </li>

                @if($page->parent)
                    <li aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </li>
                    <li>
                        <a href="{{ route('website.pages.show', $page->parent->slug) }}"
                           class="hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                            {{ $page->parent->title }}
                        </a>
                    </li>
                @endif

                <li aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>
                    <span class="text-white font-medium truncate max-w-xs block" aria-current="page">
                        {{ $page->title }}
                    </span>
                </li>
            </ol>
        </nav>

        <h1 class="text-2xl md:text-3xl font-medium text-white leading-snug">
            {{ $page->title }}
        </h1>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CONTENIDO DE LA PÁGINA
     ══════════════════════════════════════════ --}}
<section class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="min-w-0 overflow-x-hidden">
            <article class="prose prose-lg max-w-none break-words
                            prose-headings:font-medium prose-headings:text-nazareth-blue
                            prose-a:text-nazareth-blue prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-xl prose-img:max-w-full
                            prose-table:block prose-table:overflow-x-auto">
                {!! $page->content !!}
            </article>
        </div>

        {{-- Enlace de regreso (solo si tiene padre) --}}
        @if($page->parent)
            <div class="mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('website.pages.show', $page->parent->slug) }}"
                   class="inline-flex items-center text-nazareth-blue hover:text-nazareth-light font-medium transition-colors focus:outline-none focus:underline">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                    </svg>
                    Volver a {{ $page->parent->title }}
                </a>
            </div>
        @endif

    </div>
</section>

@endsection
