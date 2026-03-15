@extends('layouts.admin')

@section('title', 'Panel de control')

@section('content')

    {{-- Stat cards --}}
    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Páginas --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-nazareth-blue/10 text-nazareth-blue">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Páginas</p>
                    <p class="text-2xl font-medium text-gray-900">{{ $totalPages }}</p>
                </div>
            </div>
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-2">
                <a href="{{ route('admin.pages.index') }}"
                   class="text-xs font-medium text-nazareth-blue hover:text-nazareth-light">
                    Ver páginas &rarr;
                </a>
            </div>
        </div>

        {{-- Actividades --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-nazareth-gold/10 text-nazareth-gold">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Actividades</p>
                    <p class="text-2xl font-medium text-gray-900">{{ $totalActivities }}</p>
                </div>
            </div>
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-2">
                <a href="{{ route('admin.activities.index') }}"
                   class="text-xs font-medium text-nazareth-blue hover:text-nazareth-light">
                    Ver actividades &rarr;
                </a>
            </div>
        </div>

        {{-- Galerías --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Galerías</p>
                    <p class="text-2xl font-medium text-gray-900">{{ $totalGalleries }}</p>
                </div>
            </div>
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-2">
                <a href="{{ route('admin.galleries.index') }}"
                   class="text-xs font-medium text-nazareth-blue hover:text-nazareth-light">
                    Ver galerías &rarr;
                </a>
            </div>
        </div>

        {{-- Eventos --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-nazareth-green/10 text-nazareth-green">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Eventos</p>
                    <p class="text-2xl font-medium text-gray-900">{{ $totalEvents }}</p>
                </div>
            </div>
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-2">
                <a href="{{ route('admin.events.index') }}"
                   class="text-xs font-medium text-nazareth-blue hover:text-nazareth-light">
                    Ver eventos &rarr;
                </a>
            </div>
        </div>

    </div>

    {{-- Recent activities --}}
    <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-sm font-medium text-gray-900">Actividades recientes</h2>
            <a href="{{ route('admin.activities.index') }}"
               class="text-xs font-medium text-nazareth-blue hover:text-nazareth-light">
                Ver todas &rarr;
            </a>
        </div>

        @if ($recentActivities->isEmpty())
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto mb-3 h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-sm text-gray-500">No hay actividades aún.</p>
                <a href="{{ route('admin.activities.create') }}"
                   class="mt-3 inline-block rounded-lg bg-nazareth-blue px-4 py-2 text-sm font-medium text-white hover:bg-nazareth-light">
                    Crear primera actividad
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                Título
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recentActivities as $activity)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                    @if ($activity->excerpt)
                                        <p class="mt-0.5 text-xs text-gray-500 line-clamp-1">{{ $activity->excerpt }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php $status = $activity->status->value @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        @if ($status === 'published') bg-nazareth-green/10 text-nazareth-green
                                        @elseif ($status === 'archived') bg-yellow-100 text-yellow-700
                                        @else bg-gray-100 text-gray-600
                                        @endif">
                                        @if ($status === 'published') Publicado
                                        @elseif ($status === 'archived') Archivado
                                        @else Borrador
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $activity->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.activities.edit', $activity) }}"
                                       class="text-xs font-medium text-nazareth-blue hover:text-nazareth-light">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
