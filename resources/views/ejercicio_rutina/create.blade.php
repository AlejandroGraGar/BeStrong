@extends('layout')

@section('title', 'Añadir Ejercicios - BeStrong')

@section('content')
<div class="max-w-3xl mx-auto mt-10">

    <div class="mb-6">
        <a href="{{ route('rutinas.show', $rutina) }}"
           class="inline-flex items-center gap-2 text-gray-500 hover:text-red-500 font-medium">
            ← Volver a {{ $rutina->nombre }}
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-red-500 px-8 py-6">
            <h1 class="text-2xl font-black text-white">Añadir Ejercicios</h1>
            <p class="text-red-100 text-sm mt-1">Rutina: {{ $rutina->nombre }}</p>
        </div>

        <form action="{{ route('ejercicioRutina.create', $rutina) }}" method="POST" class="p-8 space-y-6">
            @csrf

            @if($ejerciciosDisponibles->isEmpty())
                <p class="text-orange-500 font-semibold">
                    No hay ejercicios disponibles para añadir.
                </p>
            @else

                <p class="text-gray-500 mb-4">
                    Marca los ejercicios que quieras añadir y configura sus datos.
                </p>

                @foreach($ejerciciosDisponibles as $ejercicio)
                    <div class="border rounded-xl p-4 mb-4">

                        <label class="flex items-center gap-2 font-semibold">
                            <input type="checkbox"
                                   name="ejercicios[{{ $ejercicio->id }}][selected]"
                                   value="1"
                                   class="accent-red-500">
                            {{ $ejercicio->nombre }}
                        </label>

                        <div class="grid grid-cols-2 gap-3 mt-3">

                            <input type="number"
                                   name="ejercicios[{{ $ejercicio->id }}][series]"
                                   placeholder="Series"
                                   class="border rounded-lg p-2 w-full">

                            <input type="number"
                                   name="ejercicios[{{ $ejercicio->id }}][repeticiones]"
                                   placeholder="Repeticiones"
                                   class="border rounded-lg p-2 w-full">

                            <input type="number"
                                   step="0.5"
                                   name="ejercicios[{{ $ejercicio->id }}][peso]"
                                   placeholder="Peso (kg)"
                                   class="border rounded-lg p-2 w-full">

                            <input type="number"
                                   name="ejercicios[{{ $ejercicio->id }}][orden]"
                                   placeholder="Orden"
                                   class="border rounded-lg p-2 w-full">

                        </div>
                    </div>
                @endforeach

            @endif

            <div class="flex gap-4 pt-4">
                <button type="submit"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-grey-600 font-bold py-4 px-6 rounded-xl"
                        @disabled($ejerciciosDisponibles->isEmpty())>
                    Guardar Ejercicios
                </button>

                <a href="{{ route('rutinas.show', $rutina) }}"
                   class="px-6 py-4 border rounded-xl text-gray-600">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
