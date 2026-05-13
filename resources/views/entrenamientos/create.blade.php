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

            <div class="bg-red-50 rounded-2xl px-6 py-4 text-center">
                <p class="text-sm text-gray-500">Duración</p>

                <p class="text-2xl font-black text-red-600" id="timer">
                    00:00
                </p>
            </div>

        </div>

        <div id="ejerciciosContainer" class="space-y-8">

            @foreach($entrenamiento->ejercicios as $entrenamientoEjercicio)

                <div class="border border-gray-200 rounded-3xl p-6 ejercicio-card">

                    <div class="flex justify-between items-center mb-6">

                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">
                                {{ $entrenamientoEjercicio->nombre }}
                            </h2>
                        </div>

                        <button
                            type="button"
                            class="bg-red-100 text-red-600 px-4 py-2 rounded-xl delete-ejercicio">
                            Eliminar
                        </button>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="border-b border-gray-200 text-gray-500">

                                    <th class="py-3 text-left">Serie</th>

                                    <th class="py-3 text-left">KG</th>

                                    <th class="py-3 text-left">REPS</th>

                                    <th class="py-3 text-left">✔</th>

                                    <th></th>

                                </tr>

                            </thead>

                            <tbody class="series-container">

                                <tbody class="series-container">

                                    @for($i = 1; $i <= $entrenamientoEjercicio->pivot->series; $i++)

                                        <tr class="border-b border-gray-100 serie-row">

                                            <td class="py-4 font-bold">
                                                {{ $i }}
                                            </td>

                                            <td class="py-4">
                                                <input
                                                    type="number"
                                                    value="{{ $entrenamientoEjercicio->pivot->peso }}"
                                                    class="w-24 bg-gray-100 rounded-xl px-3 py-2">
                                            </td>

                                            <td class="py-4">
                                                <input
                                                    type="number"
                                                    value="{{ $entrenamientoEjercicio->pivot->repeticiones }}"
                                                    class="w-24 bg-gray-100 rounded-xl px-3 py-2">
                                            </td>

                                            <td class="py-4">
                                                <button
                                                    type="button"
                                                    class="bg-red-500 text-white px-3 py-2 rounded-xl remove-serie">
                                                    ✕
                                                </button>
                                            </td>

                                        </tr>

                                    @endfor

</tbody>

                            </tbody>

                        </table>

                    </div>

                    <button
                        type="button"
                        class="mt-6 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-3 rounded-2xl add-serie-btn">

                        + Añadir serie

                    </button>

                </div>

            @endforeach

        </div>

        <div class="mt-10 border-t pt-8">

            <h3 class="text-xl font-bold text-gray-800 mb-4">
                Añadir ejercicio
            </h3>

            <div class="flex gap-4">

                <select
                    id="ejercicioSelect"
                    class="flex-1 bg-gray-100 rounded-2xl px-4 py-3">

                    <option value="">
                        Selecciona ejercicio
                    </option>

                    @foreach($ejercicios as $ejercicio)

                        <option value="{{ $ejercicio->id }}">
                            {{ $ejercicio->nombre }}
                        </option>

                    @endforeach

                </select>

                <button
                    type="button"
                    id="addEjercicioBtn"
                    class="bg-red-500 hover:bg-red-600 text-black font-bold px-6 rounded-2xl">

                    Añadir

                </button>

            </div>

        </div>

        <div class="mt-10">

            <button
                class="w-full bg-green-500 hover:bg-green-600 text-black font-black py-4 rounded-2xl text-lg">

                Finalizar Entrenamiento

            </button>

        </div>

    </div>

</div>

<script>

document.querySelectorAll('.add-serie-btn').forEach(button => {

    button.addEventListener('click', function () {

        const container = this.parentElement.querySelector('.series-container');

        const rows = container.querySelectorAll('.serie-row').length + 1;

        const row = document.createElement('tr');

        row.classList.add('border-b', 'border-gray-100', 'serie-row');

        row.innerHTML = `
            <td class="py-4 font-bold">
                ${rows}
            </td>

            <td class="py-4">
                <input
                    type="number"
                    class="bg-gray-100 rounded-xl px-3 py-2 w-24">
            </td>

            <td class="py-4">
                <input
                    type="number"
                    class="bg-gray-100 rounded-xl px-3 py-2 w-24">
            </td>

            <td class="py-4">
                <input type="checkbox" class="w-5 h-5">
            </td>

            <td class="py-4">
                <button
                    type="button"
                    class="text-red-500 delete-serie">
                    ✕
                </button>
            </td>
        `;

        container.appendChild(row);

        attachDeleteSerie();

    });

});

function attachDeleteSerie() {

    document.querySelectorAll('.delete-serie').forEach(button => {

        button.onclick = function () {

            this.closest('.serie-row').remove();

        };

    });

}

attachDeleteSerie();

document.querySelectorAll('.delete-ejercicio').forEach(button => {

    button.addEventListener('click', function () {

        this.closest('.ejercicio-card').remove();

    });

});

document.getElementById('addEjercicioBtn').addEventListener('click', function () {

    const select = document.getElementById('ejercicioSelect');

    const nombre = select.options[select.selectedIndex].text;

    if (!select.value) return;

    const container = document.getElementById('ejerciciosContainer');

    const div = document.createElement('div');

    div.classList.add(
        'border',
        'border-gray-200',
        'rounded-3xl',
        'p-6',
        'ejercicio-card',
        'mt-8'
    );

    div.innerHTML = `
        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold text-gray-800">
                ${nombre}
            </h2>

            <button
                type="button"
                class="bg-red-100 text-red-600 px-4 py-2 rounded-xl delete-ejercicio">

                Eliminar

            </button>

        </div>

        <table class="w-full">

            <thead>

                <tr class="border-b border-gray-200 text-gray-500">

                    <th class="py-3 text-left">Serie</th>

                    <th class="py-3 text-left">KG</th>

                    <th class="py-3 text-left">REPS</th>

                    <th class="py-3 text-left">✔</th>

                    <th></th>

                </tr>

            </thead>

            <tbody class="series-container"></tbody>

        </table>

        <button
            type="button"
            class="mt-6 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-3 rounded-2xl add-serie-btn">

            + Añadir serie

        </button>
    `;

    container.appendChild(div);

});

let seconds = 0;

function updateTimer() {

    seconds++;

    const mins = Math.floor(seconds / 60);

    const secs = seconds % 60;

    document.getElementById('timer').innerText =
        String(mins).padStart(2, '0') +
        ':' +
        String(secs).padStart(2, '0');

}

setInterval(updateTimer, 1000);

</script>

@endsection