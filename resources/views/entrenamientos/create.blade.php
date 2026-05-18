@extends('layout')

@section('title', 'Crear entrenamiento')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">

    <div class="max-w-4xl mx-auto">

        <form method="POST" action="{{ route('entrenamientos.create') }}">
            @csrf

            <div class="text-center mb-10">
                <h1 class="text-4xl font-black text-gray-600 mb-2">Nuevo Entrenamiento</h1>
                <p class="text-gray-400">Añade ejercicios y personaliza tus series</p>
            </div>

            <div id="ejerciciosContainer" class="space-y-6 mb-8"></div>

            <div id="emptyState" class="bg-gray-800/50 border-2 border-dashed border-gray-700 rounded-3xl p-12 text-center mb-8">
                <p class="text-gray-400 text-lg">No hay ejercicios todavía</p>
            </div>

            <div class="bg-gray-800/80 rounded-3xl p-6 border border-gray-700 mb-6">
                <div class="flex gap-3">
                    <select id="ejercicioSelect" class="flex-1 bg-gray-900 text-gray-600 rounded-xl px-4 py-3">
                        <option value="">Selecciona un ejercicio...</option>
                        @foreach($ejercicios as $ejercicio)
                            <option value="{{ $ejercicio->id }}">{{ $ejercicio->nombre }}</option>
                        @endforeach
                    </select>

                    <button type="button" id="addEjercicioBtn"
                        class="bg-red-500 text-gray-600 font-bold px-6 rounded-xl">
                        Añadir
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-green-500 text-gray-600 font-black py-5 rounded-2xl text-lg">
                Guardar Entrenamiento
            </button>

        </form>

    </div>

</div>

<template id="ejercicioTemplate">
    <div class="ejercicio-card bg-gray-800 rounded-3xl border border-gray-700 overflow-hidden">

        <div class="flex justify-between items-center p-6 border-b border-gray-700">
            <h2 class="ejercicio-nombre text-xl font-bold text-gray-600"></h2>

            <button type="button" class="remove-ejercicio text-red-500">
                Eliminar
            </button>
        </div>

        <input type="hidden" class="ejercicio-id">

        <div class="p-6">
            <div class="series space-y-3"></div>

            <button type="button" class="add-serie mt-4 text-gray-300">
                + Añadir serie
            </button>
        </div>

    </div>
</template>

<template id="serieTemplate">
    <div class="serie-row flex gap-4 items-center">

        <span class="serie-numero w-10 text-gray-600 font-bold"></span>

        <input type="number" class="peso-input bg-gray-800 text-gray-600 px-3 py-2 rounded-lg w-24" placeholder="kg">

        <input type="number" class="reps-input bg-gray-800 text-gray-600 px-3 py-2 rounded-lg w-24" placeholder="reps">

        <button type="button" class="remove-serie text-red-500">✕</button>

    </div>
</template>

<script>
let ejercicioIndex = 0;

const container = document.getElementById('ejerciciosContainer');
const ejercicioTemplate = document.getElementById('ejercicioTemplate');
const serieTemplate = document.getElementById('serieTemplate');

document.getElementById('addEjercicioBtn').addEventListener('click', function () {

    const select = document.getElementById('ejercicioSelect');
    if (!select.value) return;

    const index = ejercicioIndex;
    const nombre = select.options[select.selectedIndex].text;

    const clone = ejercicioTemplate.content.cloneNode(true);
    const card = clone.querySelector('.ejercicio-card');

    card.querySelector('.ejercicio-nombre').textContent = nombre;

    const hidden = card.querySelector('.ejercicio-id');
    hidden.name = `ejercicios[${index}][ejercicio_id]`;
    hidden.value = select.value;

    let serieIndex = 0;

    card.querySelector('.add-serie').addEventListener('click', function () {

        const serieClone = serieTemplate.content.cloneNode(true);
        const row = serieClone.querySelector('.serie-row');

        row.querySelector('.serie-numero').textContent = serieIndex + 1;

        row.querySelector('.peso-input').name = `ejercicios[${index}][series][${serieIndex}][peso]`;
        row.querySelector('.reps-input').name = `ejercicios[${index}][series][${serieIndex}][repeticiones]`;

        row.querySelector('.remove-serie').addEventListener('click', function () {
            row.remove();
        });

        card.querySelector('.series').appendChild(row);

        serieIndex++;
    });

    card.querySelector('.remove-ejercicio').addEventListener('click', function () {
        card.remove();
    });

    container.appendChild(clone);

    card.querySelector('.add-serie').click();

    ejercicioIndex++;
});
</script>

@endsection