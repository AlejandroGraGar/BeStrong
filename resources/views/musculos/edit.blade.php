@extends('layout')

@section('title', 'Editar Músculo')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Editar Músculo</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('musculos.update', $musculo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-2">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $musculo->nombre) }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Descripción</label>
            <textarea name="descripcion" rows="4"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $musculo->descripcion) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Imagen actual</label>
            @if($musculo->imagen)
                <img src="{{ asset('storage/'.$musculo->imagen) }}"
                     class="w-32 h-32 object-cover rounded mb-3">
            @endif

            <input type="file" name="imagen"
                class="w-full border rounded px-3 py-2 bg-white">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('musculos.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Cancelar
            </a>

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
        </div>
    </form>
</div>

@endsection
