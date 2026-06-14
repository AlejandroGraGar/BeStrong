@extends('layout')

@section('title', 'Crear Ejercicios - BeStrong')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <form id="formEjercicios" method="POST" action="{{ route('ejercicioRutina.create', $rutina) }}">
        @csrf
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <div class="w-full lg:w-2/3">
                <div class="mb-6 flex justify-between items-center">

                    <a href="{{ route('rutinas.index') }}"
                       class="inline-flex items-center gap-2 text-gray-600 hover:text-white font-medium">
                        ← Volver
                    </a>

                    <button type="submit"
                            class="bg-gray-500 text-white font-bold py-3 px-6 rounded-2xl shadow-lg transition">
                        ✔ Guardar rutina
                    </button>

                </div>

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                    <div class="bg-red-500 px-8 py-6">
                        <h1 class="text-2xl font-black text-black">Crear Ejercicios</h1>
                        <p class="text-black text-sm mt-1">Añade ejercicios a tu nueva rutina</p>
                    </div>

                    <div id="listaEjercicios" class="p-6 space-y-4">
                        <p class="text-gray-600 text-sm" id="mensajeVacio">
                            Aún no has añadido ejercicios. Usa el botón de la derecha.
                        </p>
                    </div>

                </div>

            </div>

            <div class="w-full lg:w-1/3 sticky top-10">

                <div class="bg-white rounded-3xl shadow-lg p-6">

                    <h2 class="text-2xl font-black text-gray-800 mb-2">Añadir ejercicios</h2>
                    <p class="text-sm text-gray-500 mb-6">Selecciona ejercicios para tu rutina</p>

                    <button type="button"
                            onclick="abrirModal()"
                            class="w-full bg-red-500 hover:bg-red-500 text-white font-bold py-4 rounded-2xl shadow-lg transition">
                        + Añadir ejercicio
                    </button>

                </div>

            </div>

        </div>

    </form>
</div>

<div id="modalEjercicios" class="fixed inset-0 hidden z-[99999]">

    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="cerrarModal()"></div>
        
    <div class="absolute inset-0 overflow-y-auto">
        <div class="min-h-full flex items-start justify-center p-4 py-10">
            <div class="w-full max-w-2xl bg-white rounded-[2rem] shadow-2xl animate-fadeIn">
                <div class="bg-red-500 px-6 py-5 rounded-t-[2rem] flex justify-between items-start">

                    <div class="flex-1">
                        <h2 class="text-xl font-black text-white">Añadir ejercicios</h2>
                        <p class="text-white text-sm">Selecciona ejercicios para la rutina</p>
                    </div>
                    
                    <button type="button" id="agregarEjerciciosBtn" class="mt-4 bg-gray-600 text-white hover:bg-red-500font-bold py-2 px-6 rounded-2xl transition">
                            Añadir seleccionados
                        </button>

                    <button type="button"
                            onclick="cerrarModal()"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-white text-2xl font-bold transition">
                        ×
                    </button>


                </div>

                <div class="p-5">

                    <input type="text" id="buscador" placeholder="Buscar ejercicio..."class="w-full border rounded-2xl p-3 mb-5 focus:outline-none focus:ring-2 focus:ring-red-400">

                    <div id="listaModal" class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
                        @foreach($ejerciciosDisponibles as $ejercicio)
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
function abrirModal() {
    document.getElementById('modalEjercicios').classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('modalEjercicios').classList.add('hidden');
}

function eliminarEjercicio(button) {
    const card = button.closest('[id^="ejercicio-"]');
    const id = card.id.replace('ejercicio-', '');

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

    if (document.getElementById('listaEjercicios').querySelectorAll('[id^="ejercicio-"]').length === 0) {
        document.getElementById('mensajeVacio').classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('buscador').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.ejercicio-card').forEach(card => {
            const nombre = card.querySelector('.nombre-ejercicio').textContent.toLowerCase();
            card.style.display = nombre.includes(q) ? '' : 'none';
        });
    });

    document.getElementById('agregarEjerciciosBtn').addEventListener('click', function () {

        const lista = document.getElementById('listaEjercicios');
        const seleccionados = document.querySelectorAll('.checkbox-ejercicio:checked');

        if (seleccionados.length === 0) {
            alert('Selecciona al menos un ejercicio.');
            return;
        }

        seleccionados.forEach(checkbox => {
            const id     = checkbox.dataset.id;
            const nombre = checkbox.dataset.nombre;

            if (document.getElementById('ejercicio-' + id)) return;

            document.getElementById('mensajeVacio').classList.add('hidden');

            const div = document.createElement('div');
            div.id = 'ejercicio-' + id;
            div.className = 'border rounded-2xl p-4 bg-gray-50 hover:shadow-md transition';
            div.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-base font-bold text-gray-800">${nombre}</h2>
                    <button type="button"
                            onclick="eliminarEjercicio(this)"
                            class="bg-red-500 hover:bg-red-500 text-white px-3 py-1 rounded-xl text-sm font-semibold transition">
                        Eliminar
                    </button>
                </div>
                <input type="hidden" name="ejercicios[${id}][selected]" value="1">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="number" name="ejercicios[${id}][series]"
                           placeholder="Series" min="1"
                           class="border rounded-xl p-2.5 w-full text-sm">
                    <input type="number" name="ejercicios[${id}][repeticiones]"
                           placeholder="Repeticiones" min="1"
                           class="border rounded-xl p-2.5 w-full text-sm">
                    <input type="number" step="0.5" name="ejercicios[${id}][peso]"
                           placeholder="Peso (kg)" min="0"
                           class="border rounded-xl p-2.5 w-full text-sm">
                </div>`;

            lista.appendChild(div);

            checkbox.closest('.ejercicio-card').remove();
        });

        cerrarModal();
    });
});
</script>

@endsection