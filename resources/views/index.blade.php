@extends('layout')

@section('title', 'Mis Entrenamientos - BeStrong')

@section('content')

<div class="flex flex-col lg:flex-row gap-8 mt-16">
    <div class="flex-grow-[2] bg-white rounded-3xl p-8 shadow-lg mt-6" style="flex-basis: 66%;">

        <div class="flex justify-between items-center mb-8">

            <div>
                <h1 class="text-3xl font-black text-red-600">
                    Mis Entrenamientos
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Gestiona tus rutinas de ejercicio
                </p>
            </div>

            <a href="{{ route('entrenamientos.create') }}" class="bg-red-500 btn hover:bg-red-600 text-grey-600 px-5 py-3 rounded-2xl font-bold shadow-md transition">
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
                                    Entrenamiento #{{ $entrenamiento->id }}
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
                    <div class="w-24 h-24 bg-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>

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
    <div class="flex-grow mt-6 sticky top-10 self-start" style="flex-basis: 33%;">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="pt-20 pb-8 px-6 text-center">

                <h2 class="text-2xl font-black text-gray-800">
                    {{ auth()->user()->name }}
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    @bestrong_user
                </p>
                <div class="grid grid-cols-1 gap-4 mt-8 pt-6 border-t border-gray-200">
                    <div class="bg-red-50 rounded-2xl py-5">
                        <p class="text-4xl font-black text-red-600">
                            {{ $entrenamientos->count() }}
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

@endsection