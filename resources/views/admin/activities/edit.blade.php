@extends('layouts.admin')

@section('title', 'Editar actividad')

@section('content')
    <livewire:admin.activity-form :activity="$activity" />
@endsection
