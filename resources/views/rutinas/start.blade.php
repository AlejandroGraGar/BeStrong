@extends('layout')

@section('content')

<div class="w-full max-w-screen-2xl mx-auto mt-10 px-8">

    <div class="mb-8">
        <h1 class="text-3xl font-black text-red-600">
            Entrenamiento de {{ $entrenamiento->rutina->nombre }}
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Registra tus repeticiones y pesos por serie
        </p>
    </div>

    <form action="{{ route('entrenamientos.progreso', $entrenamiento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-12">

            @foreach($entrenamiento->ejercicios as $ejercicio)

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-6 hover:shadow-md transition">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ $ejercicio->nombre }}
                        </h3>

                        <span class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full font-semibold">
                            {{ $ejercicio->pivot->series }} series
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-{{ $ejercicio->pivot->series }} gap-4">

                        @foreach(range(1, $ejercicio->pivot->series) as $i)

                            <div class="flex flex-col gap-2 bg-gray-50 rounded-xl p-3">

                                <span class="text-xs font-semibold text-gray-500">
                                    Serie {{ $i }}
                                </span>

                                <input type="number"
                                    name="ejercicios[{{ $ejercicio->id }}][{{ $i }}][repeticiones]"
                                    class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-red-200 outline-none"
                                    placeholder="Reps">

                                <input type="number"
                                    step="0.5"
                                    name="ejercicios[{{ $ejercicio->id }}][{{ $i }}][peso]"
                                    class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-red-200 outline-none"
                                    placeholder="Kg">

                            </div>

                        @endforeach

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-10">
            <button class="w-full bg-red-500 hover:bg-red-600 text-grey-600 font-bold py-4 rounded-2xl shadow-lg transition">
                Guardar progreso
            </button>
        </div>

    </form>

</div>

@endsection