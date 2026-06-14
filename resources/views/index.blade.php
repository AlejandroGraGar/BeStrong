@extends('layout')

@section('title', 'Mis Entrenamientos - BeStrong')

@section('content')

<div class="bg-white rounded-3xl p-8 ">

    <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 mb-8 justify-center">

        <div class="bg-white rounded-3xl p-8 shadow-lg" style="flex-basis: 65%;">

            <div class="flex justify-between items-center mb-8">

                <div>
                    <h1 class="text-3xl font-black text-red-600">
                        Mis Entrenamientos
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Gestiona tus rutinas de ejercicio
                    </p>
                </div>

                <a href="{{ route('entrenamientos.create') }}" class="bg-gray-600 btn text-grey-600 px-5 py-3 rounded-2xl font-bold shadow-md transition">
                    + Entrenamiento Nuevo 
                </a>

            </div>

            <div class="space-y-5">
                @forelse($entrenamientos as $entrenamiento)
                    <div class="bg-gray-50 hover:bg-red-50 border border-gray-200 rounded-3xl p-6 transition-all duration-300 hover:shadow-lg">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                            <div class="flex items-start gap-4">
                                <div>
                                    <h2 class="text-2xl font-black text-gray-800">
                                        Entrenamiento #{{ $totalEntrenamientos - $loop->index }}
                                    </h2>
                                    <p class="text-red-500 font-semibold mt-1">
                                        {{ $entrenamiento->rutina->nombre ?? 'Entrenamiento libre' }}
                                    </p>

                                    <p class="text-sm text-gray-400 mt-1">
                                        {{ $entrenamiento->fecha }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3">

                                <a href="{{ route('entrenamientos.show', $entrenamiento->id) }}" class="bg-red-500 hover:bg-red-600 btn text-grey-600 px-5 py-3 rounded-2xl font-bold shadow-md transition">
                                    Ver detalles
                                </a>

                            </div>
                        </div>
                    </div>
                @empty

                    <div class="text-center py-24 bg-red-50 rounded-3xl border-2 border-dashed border-red-300">
                        <p class="text-gray-700 font-black text-2xl">
                            No hay entrenamientos registrados
                        </p>

                        <p class="text-gray-400 mt-2">
                            Crea tu primer entrenamiento para comenzar
                        </p>
                    </div>
                @endforelse
            </div>

        </div>

        <div class="sticky top-6 self-start" style="flex-basis: 15%;">
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                <div class="pt-20 pb-8 px-6 text-center">

                    <h2 class="text-2xl font-black text-gray-800">
                        {{ auth()->user()->name }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                            <span>@</span>{{ auth()->user()->datosUsuario->nombre ?? '@bestrong_user' }}
                    </p>
                    <div class="grid grid-cols-1 gap-4 mt-8 pt-6 border-t border-gray-200">
                        <div class="bg-red-50 rounded-2xl py-5">
                            <p class="text-4xl font-black text-red-600">
                                {{ $totalEntrenamientos }}
                            </p>

                            <span class="text-sm text-gray-600 font-bold">
                                Entrenamientos Totales
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection