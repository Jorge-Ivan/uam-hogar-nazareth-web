@extends('layouts.admin')

@section('title', 'Gestionar galería')

@section('content')
    <livewire:admin.gallery-manager :gallery="$gallery" />
@endsection
