@extends('layout')

@section('title', 'Músculos')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Lista de Músculos</h1>

    @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('musculos.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Crear Músculo
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-3 px-4 text-left">Nombre</th>
                <th class="py-3 px-4 text-left">Descripción</th>
                <th class="py-3 px-4 text-left">Imagen</th>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <th class="py-3 px-4 text-center">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($musculos as $musculo)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $musculo->nombre }}</td>
                    <td class="py-3 px-4">{{ $musculo->descripcion }}</td>
                    <td class="py-3 px-4">
                        @if($musculo->imagen)
                            <img src="{{ asset('storage/'.$musculo->imagen) }}" 
                                 class="w-20 h-20 object-cover rounded">
                        @endif
                    </td>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <td class="py-3 px-4 text-center space-x-2">
                            <a href="{{ route('musculos.edit', $musculo->id) }}" 
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Editar
                            </a>

                            <form action="{{ route('musculos.destroy', $musculo->id) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Seguro que quieres eliminar este músculo?')"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Borrar
                                </button>
                            </form>
                        </td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
