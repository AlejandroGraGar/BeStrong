@extends('layout')

@section('title', 'Entrenamiento')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="mb-10">

            <h1 class="text-3xl font-black text-red-600">
                {{ $entrenamiento->rutina->nombre ?? 'Entrenamiento libre' }}
            </h1>

            <p class="text-gray-400 mt-2">
                {{ $entrenamiento->fecha }}
            </p>

        </div>

        <div class="space-y-8">

            @foreach($entrenamiento->series->groupBy('ejercicio_id') as $series)

                <div class="border border-gray-200 rounded-3xl p-6">

                    <h2 class="text-2xl font-bold text-gray-800 mb-6">
                        {{ $series->first()->ejercicio->nombre }}
                    </h2>

                    <table class="w-full">

                        <thead>

                            <tr class="border-b border-gray-200 text-gray-500">

                                <th class="text-left py-3">
                                    Serie
                                </th>

                                <th class="text-left py-3">
                                    Peso
                                </th>

                                <th class="text-left py-3">
                                    Reps
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($series->sortBy('numero') as $serie)

                                <tr class="border-b border-gray-100">

                                    <td class="py-4 font-bold">
                                        {{ $serie->numero }}
                                    </td>

                                    <td class="py-4">
                                        {{ $serie->peso }} kg
                                    </td>

                                    <td class="py-4">
                                        {{ $serie->repeticiones }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection