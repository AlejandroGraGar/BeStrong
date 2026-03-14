@extends('layout')

@section('title', 'Crear Músculo')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Crear Músculo</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('musculos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-2">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Descripción</label>
            <textarea name="descripcion" rows="4"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Imagen</label>
            <input type="file" name="imagen"
                class="w-full border rounded px-3 py-2 bg-white">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('musculos.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Cancelar
            </a>

            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Guardar
            </button>
        </div>
    </form>
</div>

@endsection
