<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('meta_title', $siteSettings->org_name ?? 'Hogar Nazareth') | Hogar Nazareth</title>
    <meta name="description" content="@yield('meta_description', 'Fundación Hogar del Anciano Nazareth')">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('meta_title', $siteSettings->org_name ?? 'Hogar Nazareth')">
    <meta property="og:description" content="@yield('meta_description', '')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_CO">

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', $siteSettings->org_name ?? 'Hogar Nazareth')">
    <meta name="twitter:description" content="@yield('meta_description', '')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Facebook --}}
    <meta property="fb:app_id" content="">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-white font-sans antialiased text-gray-900">

    {{-- Skip to content --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-white text-nazareth-blue px-4 py-2 rounded z-50 focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2">
        Ir al contenido principal
    </a>

    {{-- ===== NAVBAR ===== --}}
    <header class="bg-nazareth-blue sticky top-0 z-40 shadow-md" x-data="{ open: false }">
        <nav aria-label="Navegación principal" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('website.home') }}"
                   class="flex items-center gap-2 shrink-0 focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue rounded">
                    {{-- Heart SVG icon --}}
                    <svg class="h-8 w-8 text-nazareth-gold" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/>
                    </svg>
                    <span class="text-white font-medium text-lg leading-tight hidden sm:block">Hogar Nazareth</span>
                    <span class="text-white font-medium text-base leading-tight sm:hidden">Hogar Nazareth</span>
                </a>

                {{-- Desktop nav links --}}
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('website.home') }}"
                       class="px-3 py-2 text-sm rounded transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue
                           {{ request()->routeIs('website.home') ? 'text-white font-medium border-b-2 border-white' : 'text-white/80 hover:text-white' }}">
                        Inicio
                    </a>

                    {{-- Dynamic header pages with optional dropdowns --}}
                    @foreach($navHeaderPages as $page)
                        @if($page->children->isNotEmpty())
                            {{-- Page with subpages: dropdown --}}
                            <div class="relative" x-data="{ dropdownOpen: false }">
                                <button
                                    @click="dropdownOpen = !dropdownOpen"
                                    @click.outside="dropdownOpen = false"
                                    class="flex items-center gap-1 px-3 py-2 text-sm rounded transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue
                                        {{ request()->routeIs('website.pages.show') && request()->slug === $page->slug ? 'text-white font-medium border-b-2 border-white' : 'text-white/80 hover:text-white' }}"
                                    :aria-expanded="dropdownOpen"
                                    aria-haspopup="true"
                                >
                                    {{ $page->title }}
                                    <svg class="h-4 w-4 transition-transform" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div
                                    x-show="dropdownOpen"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50"
                                    role="menu"
                                >
                                    <a href="{{ route('website.pages.show', $page->slug) }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-nazareth-gray hover:text-nazareth-blue focus:outline-none focus:bg-nazareth-gray"
                                       role="menuitem">
                                        {{ $page->title }}
                                    </a>
                                    @foreach($page->children as $child)
                                        <a href="{{ route('website.pages.show', $child->slug) }}"
                                           class="block px-4 py-2 text-sm text-gray-600 hover:bg-nazareth-gray hover:text-nazareth-blue focus:outline-none focus:bg-nazareth-gray pl-6"
                                           role="menuitem">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ route('website.pages.show', $page->slug) }}"
                               class="px-3 py-2 text-sm rounded transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue text-white/80 hover:text-white">
                                {{ $page->title }}
                            </a>
                        @endif
                    @endforeach

                    <a href="{{ route('website.activities.index') }}"
                       class="px-3 py-2 text-sm rounded transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue
                           {{ request()->routeIs('website.activities*') ? 'text-white font-medium border-b-2 border-white' : 'text-white/80 hover:text-white' }}">
                        Actividades
                    </a>

                    <a href="{{ route('website.galleries.index') }}"
                       class="px-3 py-2 text-sm rounded transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue
                           {{ request()->routeIs('website.galleries*') ? 'text-white font-medium border-b-2 border-white' : 'text-white/80 hover:text-white' }}">
                        Galerías
                    </a>

                    <a href="{{ route('website.documents.index') }}"
                       class="px-3 py-2 text-sm rounded transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue
                           {{ request()->routeIs('website.documents*') ? 'text-white font-medium border-b-2 border-white' : 'text-white/80 hover:text-white' }}">
                        Transparencia
                    </a>

                    <a href="{{ route('website.contact') }}"
                       class="px-3 py-2 text-sm rounded transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue
                           {{ request()->routeIs('website.contact') ? 'text-white font-medium border-b-2 border-white' : 'text-white/80 hover:text-white' }}">
                        Contacto
                    </a>
                </div>

                {{-- Right side: Apoyar CTA + hamburger --}}
                <div class="flex items-center gap-3">
                    {{-- Apoyar CTA (always visible) --}}
                    <a href="{{ route('website.donations') }}"
                       class="bg-nazareth-gold text-white text-sm font-medium rounded-lg px-4 py-2 transition-colors hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue shrink-0">
                        Apoyar
                    </a>

                    {{-- Mobile hamburger --}}
                    <button
                        class="lg:hidden rounded-lg p-2 text-white/80 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 focus:ring-offset-nazareth-blue"
                        @click="open = !open"
                        :aria-expanded="open"
                        aria-label="Abrir menú de navegación"
                    >
                        <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div
                x-show="open"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="lg:hidden border-t border-white/20 py-3 space-y-1"
                role="menu"
            >
                <a href="{{ route('website.home') }}"
                   class="block px-4 py-2.5 text-sm rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold
                       {{ request()->routeIs('website.home') ? 'bg-white/10 text-white font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
                   role="menuitem">
                    Inicio
                </a>

                @foreach($navHeaderPages as $page)
                    <a href="{{ route('website.pages.show', $page->slug) }}"
                       class="block px-4 py-2.5 text-sm rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold"
                       role="menuitem">
                        {{ $page->title }}
                    </a>
                    @foreach($page->children as $child)
                        <a href="{{ route('website.pages.show', $child->slug) }}"
                           class="block px-8 py-2 text-sm rounded-lg text-white/60 hover:bg-white/10 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold"
                           role="menuitem">
                            {{ $child->title }}
                        </a>
                    @endforeach
                @endforeach

                <a href="{{ route('website.activities.index') }}"
                   class="block px-4 py-2.5 text-sm rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold
                       {{ request()->routeIs('website.activities*') ? 'bg-white/10 text-white font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
                   role="menuitem">
                    Actividades
                </a>

                <a href="{{ route('website.galleries.index') }}"
                   class="block px-4 py-2.5 text-sm rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold
                       {{ request()->routeIs('website.galleries*') ? 'bg-white/10 text-white font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
                   role="menuitem">
                    Galerías
                </a>

                <a href="{{ route('website.documents.index') }}"
                   class="block px-4 py-2.5 text-sm rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold
                       {{ request()->routeIs('website.documents*') ? 'bg-white/10 text-white font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
                   role="menuitem">
                    Transparencia
                </a>

                <a href="{{ route('website.contact') }}"
                   class="block px-4 py-2.5 text-sm rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold
                       {{ request()->routeIs('website.contact') ? 'bg-white/10 text-white font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
                   role="menuitem">
                    Contacto
                </a>
            </div>
        </nav>
    </header>

    {{-- ===== MAIN CONTENT ===== --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-nazareth-blue text-white pt-12 pb-6" aria-label="Pie de página">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 3-column grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">

                {{-- Col 1: Organization + Social --}}
                <div>
                    {{-- Logo mark --}}
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="h-7 w-7 text-nazareth-gold shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/>
                        </svg>
                        <span class="font-medium text-white text-lg">{{ $siteSettings->org_name }}</span>
                    </div>

                    @if($siteSettings->org_tagline)
                        <p class="text-white/70 text-sm leading-relaxed mb-5">{{ $siteSettings->org_tagline }}</p>
                    @endif

                    {{-- Social networks --}}
                    <div class="flex items-center gap-3">
                        @if($siteSettings->social_facebook)
                            <a href="{{ $siteSettings->social_facebook }}"
                               target="_blank" rel="noopener noreferrer"
                               class="text-white/70 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded"
                               aria-label="Facebook de Hogar Nazareth">
                                {{-- Facebook SVG --}}
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        @endif

                        @if($siteSettings->contact_whatsapp)
                            <a href="https://wa.me/{{ $siteSettings->contact_whatsapp }}"
                               target="_blank" rel="noopener noreferrer"
                               class="text-white/70 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded"
                               aria-label="WhatsApp de Hogar Nazareth">
                                {{-- WhatsApp SVG --}}
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                        @endif

                        @if($siteSettings->social_instagram)
                            <a href="{{ $siteSettings->social_instagram }}"
                               target="_blank" rel="noopener noreferrer"
                               class="text-white/70 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded"
                               aria-label="Instagram de Hogar Nazareth">
                                {{-- Instagram SVG --}}
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        @endif

                        @if($siteSettings->social_youtube)
                            <a href="{{ $siteSettings->social_youtube }}"
                               target="_blank" rel="noopener noreferrer"
                               class="text-white/70 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded"
                               aria-label="YouTube de Hogar Nazareth">
                                {{-- YouTube SVG --}}
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Col 2: Institutional links --}}
                <div>
                    <h2 class="text-white font-medium text-base mb-4">Navegación</h2>
                    <ul class="space-y-2">
                        @foreach($navFooterPages as $page)
                            <li>
                                <a href="{{ route('website.pages.show', $page->slug) }}"
                                   class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                                    {{ $page->title }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('website.activities.index') }}"
                               class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                                Actividades
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('website.galleries.index') }}"
                               class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                                Galerías
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('website.documents.index') }}"
                               class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                                Transparencia
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('website.donations') }}"
                               class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                                Donaciones
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Col 3: Contact info --}}
                <div>
                    <h2 class="text-white font-medium text-base mb-4">Contacto</h2>
                    <ul class="space-y-3">

                        @if($siteSettings->contact_address)
                            <li class="flex items-start gap-2.5">
                                <svg class="h-5 w-5 text-nazareth-gold shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-white/70 text-sm leading-relaxed">{{ $siteSettings->contact_address }}</span>
                            </li>
                        @endif

                        @if($siteSettings->contact_phone)
                            <li class="flex items-center gap-2.5">
                                <svg class="h-5 w-5 text-nazareth-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:{{ $siteSettings->contact_phone }}"
                                   class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                                    {{ $siteSettings->contact_phone }}
                                </a>
                            </li>
                        @endif

                        @if($siteSettings->contact_whatsapp)
                            <li class="flex items-center gap-2.5">
                                <svg class="h-5 w-5 text-nazareth-gold shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                <a href="https://wa.me/{{ $siteSettings->contact_whatsapp }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                                    WhatsApp
                                </a>
                            </li>
                        @endif

                        @if($siteSettings->contact_email)
                            <li class="flex items-center gap-2.5">
                                <svg class="h-5 w-5 text-nazareth-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $siteSettings->contact_email }}"
                                   class="text-white/70 hover:text-white text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded break-all">
                                    {{ $siteSettings->contact_email }}
                                </a>
                            </li>
                        @endif

                        @if($siteSettings->contact_schedule)
                            <li class="flex items-center gap-2.5">
                                <svg class="h-5 w-5 text-nazareth-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-white/70 text-sm">{{ $siteSettings->contact_schedule }}</span>
                            </li>
                        @endif

                    </ul>
                </div>

            </div>{{-- end 3-col grid --}}

            {{-- Attribution band --}}
            <div class="border-t border-white/10 py-4 mt-2 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Fundación Hogar del Anciano Nazareth &middot;
                Sitio web desarrollado como práctica social por
                <a href="https://www.linkedin.com/in/jorgecarrillog/"
                   target="_blank" rel="noopener noreferrer"
                   class="text-gray-400 hover:text-gray-200 hover:underline underline-offset-2 focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                    Jorge Carrillo
                </a>
                &middot;
                <a href="https://www.autonoma.edu.co/"
                   target="_blank" rel="noopener noreferrer"
                   class="text-gray-400 hover:text-gray-200 hover:underline underline-offset-2 focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
                    Universidad Autónoma de Manizales
                </a>
            </div>

        </div>
    </footer>

    @livewireScripts
    @stack('scripts')

</body>
</html>
