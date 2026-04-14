@extends('layouts.admin')

@section('title', 'Crear usuario')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-1 text-sm text-nazareth-blue hover:underline">
            &larr; Volver a usuarios
        </a>
    </div>

    <livewire:admin.user-form />
@endsection
