@extends('layout')

@section('title', 'Ejercicios')

@section('content')

<h1>Lista de Ejercicios</h1>

<table id="tablaEjercicios">
    <caption>Tabla de Ejercicios</caption>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Imagen</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($exercises as $exercise)
            <tr>
                <td>{{ $exercise->name }}</td>
                <td>{{ $exercise->description ?? 'Sin descripción' }}</td>
                <td>
                    @if($exercise->image_url)
                        <img src="{{ $exercise->image_url }}" alt="{{ $exercise->name }}" width="150">
                    @else
                        No disponible
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
