@extends('layout')

@section('title', 'Editar Rutina - BeStrong')

@section('content')
<div class="max-w-2xl mx-auto mt-10">

    <div class="mb-6">
        <a href="{{ route('rutinas.index') }}"
           class="inline-flex items-center gap-2 text-gray-500 hover:text-red-500 font-medium">

            Volver a rutinas
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-blue-500 px-8 py-6">
            <h1 class="text-2xl font-black text-white">Editar Rutina</h1>
            <p class="text-blue-100 text-sm mt-1">
                Modifica los datos de tu rutina
            </p>
        </div>

        <form action="{{ route('rutinas.update', $rutina) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $rutina->nombre) }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none">

                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Descripción
                </label>

                <textarea name="descripcion"
                          rows="4"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none">{{ old('descripcion', $rutina->descripcion) }}</textarea>

                @error('descripcion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">

                <button type="submit"
                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg">
                    Guardar cambios
                </button>

                <a href="{{ route('rutinas.index') }}"
                   class="px-6 py-4 border-2 border-gray-200 hover:border-gray-300 text-gray-600 font-bold rounded-xl">
                    Cancelar
                </a>

            </div>

        </form>
    </div>
</div>
@endsection
