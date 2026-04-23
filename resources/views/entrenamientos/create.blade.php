@extends('layout')

@section('title', 'Crear Entrenamiento')

@section('content')
<h1>Crear Entrenamiento</h1>

<form action="{{ route('entrenamientos.create') }}" method="POST">
    @csrf


    <div class="mb-3">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control">
    </div>

    <div class="mb-3">
        <label for="duracion">Duración (minutos)</label>
        <input type="number" name="duracion" id="duracion" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Crear</button>
    <a href="{{ route('entrenamientos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
