@extends('layout')

@section('title', 'Ver Entrenamiento')

@section('content')
<h1>Entrenamiento #{{ $entrenamiento->id }}</h1>

<ul class="list-group">
    <li class="list-group-item"><strong>Usuario:</strong> {{ $entrenamiento->usuario->nombre ?? 'N/A' }}</li>
    <li class="list-group-item"><strong>Rutina:</strong> {{ $entrenamiento->rutina->nombre ?? 'N/A' }}</li>
    <li class="list-group-item"><strong>Fecha:</strong> {{ $entrenamiento->fecha }}</li>
    <li class="list-group-item"><strong>Duración:</strong> {{ $entrenamiento->duracion }} minutos</li>
</ul>

<a href="{{ route('entrenamientos.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection
