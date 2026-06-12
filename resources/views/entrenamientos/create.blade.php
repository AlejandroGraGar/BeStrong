@extends('layout')

@section('title', 'Crear entrenamiento')

@section('content')

<div class="max-w-7xl mx-auto mt-10 px-4">

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <div class="w-full lg:w-2/3">

            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('rutinas.index') }}"
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-red-500 font-medium">
                    ← Volver
                </a>
                <button form="formEntrenamiento"
                        type="submit"
                        class="bg-green-500 hover:bg-green-600 text-gray-600 font-bold py-3 px-6 rounded-2xl shadow-lg transition">
                    ✔ Guardar Entrenamiento
                </button>
            </div>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                <div class="bg-red-500 px-8 py-6">
                    <h1 class="text-2xl font-black text-gray-600">Nuevo Entrenamiento</h1>
                    <p class="text-red-100 text-sm mt-1">Añade ejercicios y personaliza tus series</p>
                </div>

                <form id="formEntrenamiento"
                      method="POST"
                      action="{{ route('entrenamientos.create') }}"
                      class="p-6">
                    @csrf

                    <input type="hidden" name="duracion" id="duracionInput">

                    <div class="bg-gray-50 rounded-2xl p-5 mb-6 text-center border border-gray-100">
                        <p class="text-gray-400 text-sm mb-1">Duración del entrenamiento</p>
                        <div id="timer" class="text-4xl font-black text-green-500 tracking-wider">
                            00:00:00
                        </div>
                    </div>

                    <div id="emptyState" class="border-2 border-dashed border-gray-200 rounded-2xl p-10 text-center mb-4">
                        <p class="text-gray-400">Aún no hay ejercicios. Usa el botón de la derecha.</p>
                    </div>

                    <div id="ejerciciosContainer" class="space-y-4"></div>

                </form>

            </div>

        </div>

        <div class="w-full lg:w-1/3 sticky top-10">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-2xl font-black text-gray-800 mb-2">Añadir ejercicios</h2>
                <p class="text-sm text-gray-500 mb-6">Selecciona ejercicios para tu entrenamiento</p>
                <button type="button"
                        onclick="abrirModal()"
                        class="w-full bg-red-500 hover:bg-red-600 text-gray-600 font-bold py-4 rounded-2xl shadow-lg transition">
                    + Añadir ejercicio
                </button>
            </div>
        </div>

    </div>

</div>

<div id="modalEjercicios" class="fixed inset-0 hidden z-[99999]">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="cerrarModal()"></div>
    <div class="absolute inset-0 overflow-y-auto">
        <div class="min-h-full flex items-start justify-center p-4 py-10">
            <div class="w-full max-w-2xl bg-white rounded-[2rem] shadow-2xl animate-fadeIn">

                <div class="bg-red-500 px-6 py-5 flex justify-between items-center rounded-t-[2rem]">
                    <div>
                        <h2 class="text-xl font-black text-gray-600">Añadir ejercicios</h2>
                        <p class="text-red-100 text-sm">Selecciona ejercicios para el entrenamiento</p>
                    </div>
                    <button type="button"
                            onclick="cerrarModal()"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-gray-600 text-2xl font-bold transition">
                        ×
                    </button>
                </div>

                <div class="p-5">
                    <input type="text"
                           id="buscador"
                           placeholder="Buscar ejercicio..."
                           class="w-full border rounded-2xl p-3 mb-5 focus:outline-none focus:ring-2 focus:ring-red-400">

                    <div id="listaModal" class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
                        @foreach($ejercicios as $ejercicio)
                            <div class="ejercicio-card border rounded-xl p-3 hover:bg-gray-50 transition">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox"
                                           class="checkbox-ejercicio accent-red-500"
                                           data-id="{{ $ejercicio->id }}"
                                           data-nombre="{{ $ejercicio->nombre }}">
                                    <span class="nombre-ejercicio text-sm font-medium text-gray-800">
                                        {{ $ejercicio->nombre }}
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="button"
                            id="agregarEjerciciosBtn"
                            class="w-full mt-5 bg-red-500 hover:bg-red-600 text-gray-600 font-bold py-3 rounded-2xl transition">
                        Añadir seleccionados
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(.95); }
    to   { opacity: 1; transform: scale(1); }
}
.animate-fadeIn { animation: fadeIn .2s ease; }
</style>

<script>
let ejercicioIndex = 0;

function abrirModal() {
    document.getElementById('modalEjercicios').classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('modalEjercicios').classList.add('hidden');
}

function eliminarEjercicio(button) {
    const card = button.closest('[id^="ejercicio-tmp-"]');
    const id   = card.dataset.id;
    const nombre = card.querySelector('h2').textContent.trim();

    const nuevoCheck = document.createElement('div');
    nuevoCheck.className = 'ejercicio-card border rounded-xl p-3 hover:bg-gray-50 transition';
    nuevoCheck.innerHTML = `
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" class="checkbox-ejercicio accent-red-500"
                   data-id="${id}" data-nombre="${nombre}">
            <span class="nombre-ejercicio text-sm font-medium text-gray-800">${nombre}</span>
        </label>`;
    document.getElementById('listaModal').appendChild(nuevoCheck);

    card.remove();

    const container = document.getElementById('ejerciciosContainer');
    if (container.querySelectorAll('[id^="ejercicio-tmp-"]').length === 0) {
        document.getElementById('emptyState').classList.remove('hidden');
    }
}

function eliminarSerie(button) {
    button.closest('.serie-row').remove();
}

document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('buscador').addEventListener('keyup', function () {
        const filtro = this.value.toLowerCase();
        document.querySelectorAll('.ejercicio-card').forEach(card => {
            const nombre = card.querySelector('.nombre-ejercicio').textContent.toLowerCase();
            card.style.display = nombre.includes(filtro) ? '' : 'none';
        });
    });

    document.getElementById('agregarEjerciciosBtn').addEventListener('click', function () {

        const seleccionados = document.querySelectorAll('.checkbox-ejercicio:checked');

        if (seleccionados.length === 0) {
            alert('Selecciona al menos un ejercicio.');
            return;
        }

        const container = document.getElementById('ejerciciosContainer');
        document.getElementById('emptyState').classList.add('hidden');

        seleccionados.forEach(checkbox => {
            const id     = checkbox.dataset.id;
            const nombre = checkbox.dataset.nombre;
            const index  = ejercicioIndex++;

            const card = document.createElement('div');
            card.id = `ejercicio-tmp-${index}`;
            card.dataset.id = id;
            card.className = 'border rounded-2xl p-4 bg-gray-50 hover:shadow-md transition';
            card.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-base font-bold text-gray-800">${nombre}</h2>
                    <button type="button"
                            onclick="eliminarEjercicio(this)"
                            class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-xl text-sm font-semibold transition">
                        Eliminar
                    </button>
                </div>
                <input type="hidden" name="ejercicios[${index}][ejercicio_id]" value="${id}">
                <div class="series space-y-3 mb-3"></div>
                <button type="button"
                        onclick="agregarSerie(this, ${index})"
                        class="text-sm text-red-500 hover:text-red-700 font-semibold transition">
                    + Añadir serie
                </button>`;

            container.appendChild(card);
            checkbox.closest('.ejercicio-card').remove();

            // Añadir primera serie automáticamente
            agregarSerie(card.querySelector('button[onclick^="agregarSerie"]'), index);
        });

        cerrarModal();
    });
});

const serieCounters = {};

function agregarSerie(button, index) {
    if (!serieCounters[index]) serieCounters[index] = 0;

    const serieIndex = serieCounters[index]++;
    const numero     = serieIndex + 1;
    const container  = button.closest('[id^="ejercicio-tmp-"]').querySelector('.series');

    const row = document.createElement('div');
    row.className = 'serie-row flex gap-3 items-center';
    row.innerHTML = `
        <span class="w-8 text-sm font-bold text-gray-500">${numero}</span>
        <input type="number"
               name="ejercicios[${index}][series][${serieIndex}][peso]"
               placeholder="kg" min="0" step="0.5"
               class="border rounded-xl p-2.5 w-full text-sm">
        <input type="number"
               name="ejercicios[${index}][series][${serieIndex}][repeticiones]"
               placeholder="reps" min="1"
               class="border rounded-xl p-2.5 w-full text-sm">
        <button type="button"
                onclick="eliminarSerie(this)"
                class="text-red-400 hover:text-red-600 font-bold text-lg transition">
            ✕
        </button>`;

    container.appendChild(row);
}

let seconds  = 0;
const timer  = document.getElementById('timer');
const duracionInput = document.getElementById('duracionInput');

function updateTimer() {
    const hrs  = String(Math.floor(seconds / 3600)).padStart(2, '0');
    const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
    const secs = String(seconds % 60).padStart(2, '0');
    const tiempo = `${hrs}:${mins}:${secs}`;
    timer.textContent = tiempo;
    duracionInput.value = tiempo;
}

updateTimer();
setInterval(() => { seconds++; updateTimer(); }, 1000);
</script>

@endsection