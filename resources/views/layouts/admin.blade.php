<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') — Hogar Nazareth</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }"
      :class="sidebarOpen ? 'overflow-hidden lg:overflow-auto' : ''">

    {{-- Mobile overlay --}}
    <div
        class="fixed inset-0 z-20 bg-black/50 lg:hidden"
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
    ></div>

    {{-- Sidebar: siempre fixed, no participa en el flujo del documento --}}
    <div class="flex">
        <aside
            class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-gray-900 text-white transition-transform duration-200"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            {{-- Logo --}}
            <div class="flex h-16 items-center gap-3 border-b border-gray-700 px-4">
                <img src="/images/logo.png"
                     alt="Hogar Nazareth"
                     class="h-10 w-auto shrink-0">
                <p class="text-xs text-gray-400 leading-tight">Panel de<br>administración</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4">
                <ul class="space-y-1">

                    {{-- Panel --}}
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.dashboard')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Panel
                        </a>
                    </li>

                    {{-- Páginas --}}
                    <li>
                        <a href="{{ route('admin.pages.index') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.pages*')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Páginas
                        </a>
                    </li>

                    {{-- Actividades --}}
                    <li>
                        <a href="{{ route('admin.activities.index') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.activities*')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            Actividades
                        </a>
                    </li>

                    {{-- Galerías --}}
                    <li>
                        <a href="{{ route('admin.galleries.index') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.galleries*')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Galerías
                        </a>
                    </li>

                    {{-- Eventos --}}
                    <li>
                        <a href="{{ route('admin.events.index') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.events*')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Eventos
                        </a>
                    </li>

                    {{-- Documentos --}}
                    <li>
                        <a href="{{ route('admin.documents.index') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.documents*')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Documentos
                        </a>
                    </li>

                    @if(auth()->user()?->role === \App\Enums\UserRole::Admin)
                    {{-- Usuarios --}}
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.users*')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Usuarios
                        </a>
                    </li>

                    {{-- Configuración --}}
                    <li>
                        <a href="{{ route('admin.settings') }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.settings*')
                                  ? 'bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue rounded-l-none'
                                  : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Configuración
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>

            {{-- Logout --}}
            <div class="border-t border-gray-700 p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition-colors hover:bg-gray-800 hover:text-white">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content: margen izquierdo = ancho del sidebar en desktop --}}
        <div class="flex min-h-screen flex-1 flex-col lg:pl-64">

            {{-- Top bar: sticky, siempre visible al hacer scroll --}}
            <header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6 shadow-sm">

                {{-- Mobile hamburger --}}
                <button
                    class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-nazareth-blue lg:hidden"
                    @click="sidebarOpen = !sidebarOpen"
                    aria-label="Abrir menú"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Page title --}}
                <h1 class="text-base font-medium text-gray-800 lg:text-lg">
                    @yield('title', 'Panel')
                </h1>

                {{-- User menu --}}
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->role === \App\Enums\UserRole::Admin ? 'Administrador' : 'Editor' }}</p>
                    </div>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-nazareth-blue text-sm font-medium text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mx-6 mt-4 flex items-center gap-3 rounded-lg bg-nazareth-green/10 border border-nazareth-green/30 px-4 py-3 text-sm text-nazareth-green">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-4 flex items-center gap-3 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page content: scroll natural del body, sin contenedor artificial --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            {{-- Atribución del desarrollador --}}
            <footer class="border-t border-gray-200 bg-white px-6 py-3">
                <p class="text-center text-xs text-gray-400">
                    Práctica social universitaria &middot;
                    Desarrollado por
                    <a href="https://www.linkedin.com/in/jorgecarrillog/"
                       target="_blank" rel="noopener noreferrer"
                       class="hover:text-gray-600 hover:underline underline-offset-2">
                        Jorge Carrillo
                    </a>
                    &middot;
                    <a href="https://www.autonoma.edu.co/"
                       target="_blank" rel="noopener noreferrer"
                       class="hover:text-gray-600 hover:underline underline-offset-2">
                        Universidad Autónoma de Manizales
                    </a>
                    &middot; 2026
                </p>
            </footer>
        </div>
    </div>

    @livewireScripts
</body>
</html>
