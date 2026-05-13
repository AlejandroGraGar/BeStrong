@extends('layout')

@section('title', 'Entrenamiento')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="flex justify-between items-center mb-10">

            <div>
                <h1 class="text-3xl font-black text-red-600">
                    {{ $entrenamiento->rutina->nombre ?? 'Entrenamiento libre' }}
                </h1>

                <p class="text-gray-400 mt-2">
                    {{ $entrenamiento->fecha }}
                </p>
            </div>
        </div>

        <div id="ejerciciosContainer" class="space-y-8">

            @foreach($entrenamiento->ejercicios as $entrenamientoEjercicio)

                <div class="border border-gray-200 rounded-3xl p-6 ejercicio-card">

                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $entrenamientoEjercicio->nombre }}
                        </h2>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="border-b border-gray-200 text-gray-500">

                                    <th class="py-3 text-left">Serie</th>
                                    <th class="py-3 text-left">KG</th>
                                    <th class="py-3 text-left">REPS</th>

                                </tr>

                            </thead>

                            <tbody>

                                @for($i = 1; $i <= $entrenamientoEjercicio->pivot->series; $i++)

                                    <tr class="border-b border-gray-100">

                                        <td class="py-4 font-bold text-gray-700">
                                            {{ $i }}
                                        </td>

                                        <td class="py-4 font-semibold text-gray-700">
                                            {{ $entrenamientoEjercicio->pivot->peso }} kg
                                        </td>

                                        <td class="py-4 font-semibold text-gray-700">
                                            {{ $entrenamientoEjercicio->pivot->repeticiones }}
                                        </td>

                                    </tr>

                                @endfor

                            </tbody>

                        </table>

                    </div>

                </div>

            @endforeach

        </div>

        <script>
            let seconds = 0;

            function updateTimer() {
                seconds++;

                const mins = Math.floor(seconds / 60);
                const secs = seconds % 60;

                document.getElementById('timer').innerText =
                    String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
            }

            setInterval(updateTimer, 1000);
        </script>

    </div>

</div>

@endsection