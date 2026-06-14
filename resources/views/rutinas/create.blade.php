@extends('layout')

@section('title', 'Crear Rutina')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
<a href="{{ route('rutinas.index') }}"
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-red-500 font-medium">
                    ← Volver
                </a>
    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-red-500 px-8 py-6">
            <h1 class="text-2xl font-black text-grey-600">Crear Rutina</h1>
            <p class="text-red-100 text-sm mt-1">Configura tu rutina</p>
        </div>

        <form method="POST" action="{{ route('rutinas.create') }}" class="p-8 space-y-6">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-2">Nombre</label>
                <input type="text" name="nombre" class="w-full px-4 py-3 border rounded-xl" required>
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-2">Descripción</label>
                <textarea name="descripcion" class="w-full px-4 py-3 border rounded-xl"></textarea>
            </div>

            <button class="w-full bg-red-500 text-grey-600 py-3 rounded-xl font-bold">
                Crear Rutina
            </button>
            
        </form>

    </div>
</div>
@endsection
