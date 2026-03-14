@extends('layout')

@section('title', 'Entrenamientos')

@section('content')
<h1>Lista de Entrenamientos</h1>

<a href="{{ route('entrenamientos.create') }}" class="btn btn-primary">Crear Entrenamiento</a>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Rutina</th>
            <th>Fecha</th>
            <th>Duración (min)</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entrenamientos as $entrenamiento)
            <tr>
                <td>{{ $entrenamiento->id }}</td>
                <td>{{ $entrenamiento->usuario->nombre ?? 'N/A' }}</td>
                <td>{{ $entrenamiento->rutina->nombre ?? 'N/A' }}</td>
                <td>{{ $entrenamiento->fecha }}</td>
                <td>{{ $entrenamiento->duracion }}</td>
                <td>
                    <a href="{{ route('entrenamientos.show', $entrenamiento->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('entrenamientos.update', $entrenamiento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('entrenamientos.delete', $entrenamiento->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este entrenamiento?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
