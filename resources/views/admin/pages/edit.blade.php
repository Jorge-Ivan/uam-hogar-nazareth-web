@extends('layouts.admin')

@section('title', 'Editar página')

@section('content')
    <livewire:admin.page-form :page="$page" />
@endsection
