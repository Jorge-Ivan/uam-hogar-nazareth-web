@extends('layouts.admin')

@section('title', 'Editar evento')

@section('content')
    <livewire:admin.event-form :event="$event" />
@endsection
