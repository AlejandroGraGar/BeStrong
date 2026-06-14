@extends('layout')

@section('title', 'Editar Ejercicios - BeStrong')

@section('content')

<div class="max-w-7xl mx-auto mt-10">
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <div class="w-full lg:w-2/3">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('rutinas.index', $rutina) }}"
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-red-500 font-medium">
                    Volver a {{ $rutina->nombre }}
                </a>
                <button form="formEjercicios"
                        type="submit"
                        class="bg-gray-500 text-white font-bold py-3 px-6 rounded-2xl shadow-lg transition">
                     Guardar cambios
                </button>
            </div>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                <div class="bg-gray-500 px-8 py-6">
                    <h1 class="text-2xl font-black text-gray-600">
                        Editar Ejercicios
                    </h1>
                    <p class="text-blue-100 text-sm mt-1">
                        Rutina: {{ $rutina->nombre }}
                    </p>
                </div>

                <form id="formEjercicios"
                      action="{{ route('ejercicioRutina.update', $rutina) }}"
                      method="POST"
                      class="p-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div id="listaEjercicios" class="space-y-3">
                        @foreach($rutina->ejercicios as $ejercicio)
                            <div id="ejercicio-{{ $ejercicio->id }}"
                                 class="border rounded-2xl p-4 bg-gray-50 hover:shadow-md transition">
                                <div class="flex justify-between items-center mb-3">
                                    <h2 class="text-base font-bold text-gray-800">
                                        {{ $ejercicio->nombre }}
                                    </h2>
                                    <button type="button"
                                            onclick="eliminarEjercicio(this)"
                                            class="bg-gray-100 hover:bg-gray-200 text-white px-3 py-1 rounded-xl text-sm font-semibold transition">
                                        Eliminar
                                    </button>
                                </div>

                                <input type="hidden"
                                       name="ejercicios[{{ $ejercicio->id }}][selected]"
                                       value="1">

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <input type="number"
                                           name="ejercicios[{{ $ejercicio->id }}][series]"
                                           value="{{ $ejercicio->pivot->series }}"
                                           placeholder="Series"
                                           class="border rounded-xl p-2.5 w-full text-sm">

                                    <input type="number"
                                           name="ejercicios[{{ $ejercicio->id }}][repeticiones]"
                                           value="{{ $ejercicio->pivot->repeticiones }}"
                                           placeholder="Repeticiones"
                                           class="border rounded-xl p-2.5 w-full text-sm">

                                    <input type="number"
                                           step="0.5"
                                           name="ejercicios[{{ $ejercicio->id }}][peso]"
                                           value="{{ $ejercicio->pivot->peso }}"
                                           placeholder="Peso (kg)"
                                           class="border rounded-xl p-2.5 w-full text-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full lg:w-1/3 sticky top-10">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-2xl font-black text-white-800 mb-2">
                    Añadir ejercicios
                </h2>
                <p class="text-sm text-gray-500 mb-6">
                    Agrega nuevos ejercicios a tu rutina
                </p>
                <button type="button" onclick="abrirModal()" class="w-full bg-blue text-gray-600 font-bold py-4 rounded-2xl shadow-lg transition">
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
                <div class="bg-gray-500 px-6 py-5 flex justify-between items-center rounded-t-[2rem]">
                    <div>
                        <h2 class="text-xl font-black text-gray-600">
                            Añadir ejercicios
                        </h2>
                        <p class="text-red-100 text-sm">
                            Selecciona ejercicios para la rutina
                        </p>
                    </div>
                    <button type="button"
                            id="cerrarModalBtn"
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

                    <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
                        @foreach($ejercicios as $ejercicio)
                            @if(!$rutina->ejercicios->contains($ejercicio->id))
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
                            @endif
                        @endforeach
                    </div>

                    <button type="button"
                            id="agregarEjerciciosBtn"
                            class="w-full mt-5 bg-gray-500 hover:bg-gray-600 text-gray-600 font-bold py-3 rounded-2xl transition">
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
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn .2s ease;
}
</style>

<script>
function abrirModal() {
    document.getElementById('modalEjercicios').classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('modalEjercicios').classList.add('hidden');
}

function eliminarEjercicio(button) {
    button.closest('[id^="ejercicio-"]').remove();
}

document.addEventListener('DOMContentLoaded', function () {
    const agregarBtn = document.getElementById('agregarEjerciciosBtn');

    function agregarEjercicios() {
        let lista = document.getElementById('listaEjercicios');

        document.querySelectorAll('.checkbox-ejercicio:checked').forEach(checkbox => {
            let id = checkbox.dataset.id;
            let nombre = checkbox.dataset.nombre;

            if (document.getElementById('ejercicio-' + id)) return;

            let div = document.createElement('div');
            div.id = 'ejercicio-' + id;
            div.className = 'border rounded-2xl p-4 bg-gray-50 hover:shadow-md transition';
            div.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-base font-bold text-gray-800">
                        ${nombre}
                    </h2>
                    <button type="button"
                            onclick="eliminarEjercicio(this)"
                            class="bg-gray-100 hover:bg-gray-200 text-white px-3 py-1 rounded-xl text-sm font-semibold transition">
                        Eliminar
                    </button>
                </div>
                <input type="hidden" name="ejercicios[${id}][selected]" value="1">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="number" name="ejercicios[${id}][series]" placeholder="Series" class="border rounded-xl p-2.5 w-full text-sm">
                    <input type="number" name="ejercicios[${id}][repeticiones]" placeholder="Repeticiones" class="border rounded-xl p-2.5 w-full text-sm">
                    <input type="number" step="0.5" name="ejercicios[${id}][peso]" placeholder="Peso (kg)" class="border rounded-xl p-2.5 w-full text-sm">
                </div>
            `;

            lista.appendChild(div);
            checkbox.closest('.ejercicio-card').remove();
        });

        cerrarModal();
    }

    document.getElementById('buscador').addEventListener('keyup', function () {
        let filtro = this.value.toLowerCase();
        document.querySelectorAll('.ejercicio-card').forEach(card => {
            let nombre = card.querySelector('.nombre-ejercicio').innerText.toLowerCase();
            card.style.display = nombre.includes(filtro) ? '' : 'none';
        });
    });

    agregarBtn.addEventListener('click', agregarEjercicios);
});
</script>

@endsection