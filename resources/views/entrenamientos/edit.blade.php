@extends('layout')

@section('title', 'Editar Entrenamiento')

@section('content')
<h1>Editar Entrenamiento</h1>

<form action="{{ route('entrenamientos.update', $entrenamiento->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="usuario_id">Usuario</label>
        <select name="usuario_id" id="usuario_id" class="form-control">
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}" {{ $entrenamiento->usuario_id == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="rutina_id">Rutina</label>
        <select name="rutina_id" id="rutina_id" class="form-control">
            @foreach($rutinas as $rutina)
                <option value="{{ $rutina->id }}" {{ $entrenamiento->rutina_id == $rutina->id ? 'selected' : '' }}>
                    {{ $rutina->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $entrenamiento->fecha }}">
    </div>

    <div class="mb-3">
        <label for="duracion">Duración (minutos)</label>
        <input type="number" name="duracion" id="duracion" class="form-control" value="{{ $entrenamiento->duracion }}">
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('entrenamientos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
