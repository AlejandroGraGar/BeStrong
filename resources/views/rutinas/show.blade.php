@extends('layout')

@section('title', 'Rutina - ' . $rutina->nombre)

@section('content')
<div class="max-w-4xl mx-auto mt-10">

    <div class="mb-6">
        <a href="{{ route('rutinas.index') }}"
           class="inline-flex items-center gap-2 text-gray-500 hover:text-red-500 font-medium">
            ← Volver
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-red-500 px-8 py-6">
            <h1 class="text-3xl font-black text-white">
                {{ $rutina->nombre }}
            </h1>

            @if($rutina->descripcion)
                <p class="text-red-100 mt-2">
                    {{ $rutina->descripcion }}
                </p>
            @endif
        </div>

        <div class="p-8">

            <h2 class="text-xl font-bold mb-6 text-gray-800">
                Ejercicios
            </h2>

            @if($rutina->ejercicios->isEmpty())
                <p class="text-gray-500">
                    Esta rutina no tiene ejercicios todavía.
                </p>
            @else
                <div class="space-y-4">

                    @foreach($rutina->ejercicios as $ejercicio)
                        <div class="border rounded-xl p-4 flex justify-between items-center">

                            <div>
                                <p class="font-bold text-gray-800">
                                    {{ $ejercicio->nombre }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Series: {{ $ejercicio->pivot->series ?? '-' }} |
                                    Reps: {{ $ejercicio->pivot->repeticiones ?? '-' }} |
                                    Peso: {{ $ejercicio->pivot->peso ?? '-' }} kg
                                </p>
                            </div>

                            <div class="text-sm text-gray-400">
                                Orden: {{ $ejercicio->pivot->orden ?? '-' }}
                            </div>

                        </div>
                    @endforeach

                </div>
            @endif

        </div>
    </div>

</div>
@endsection
