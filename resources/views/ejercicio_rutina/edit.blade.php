@extends('layout')

@section('title', 'Editar Ejercicios - BeStrong')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('rutinas.index', $rutina) }}"
           class="inline-flex items-center gap-2 text-grey-600 hover:text-red-500 font-medium">
            Volver a {{ $rutina->nombre }}
        </a>

        <button form="formEjercicios" type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-grey-600 font-bold py-3 px-6 rounded-xl shadow-lg">
            ✏️ Actualizar
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-blue-500 px-8 py-6">
            <h1 class="text-2xl font-black text-white">Editar Ejercicios</h1>
            <p class="text-blue-100 text-sm mt-1">Rutina: {{ $rutina->nombre }}</p>
        </div>

        <form id="formEjercicios" action="{{ route('ejercicioRutina.update', $rutina) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <input type="text" id="buscador"
                   placeholder="Buscar ejercicio..."
                   class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">

            <div id="listaEjercicios" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">

                @foreach($ejercicios as $ejercicio)

                    @php
                        $pivot = $rutina->ejercicios->find($ejercicio->id)?->pivot;
                    @endphp

                    <div class="ejercicio-card border rounded-xl p-4 transition hover:shadow-md cursor-pointer">

                        <label class="flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-3">
                                <input type="checkbox"
                                       name="ejercicios[{{ $ejercicio->id }}][selected]"
                                       value="1"
                                       class="checkbox-ejercicio accent-blue-500"
                                       {{ $pivot ? 'checked' : '' }}>

                                <span class="nombre-ejercicio font-semibold text-gray-800">
                                    {{ $ejercicio->nombre }}
                                </span>
                            </div>

                            <span class="text-sm text-gray-400">Editar →</span>
                        </label>

                        <div class="grid grid-cols-2 gap-3 mt-4 inputs-ejercicio {{ $pivot ? '' : 'hidden' }}">

                            <input type="number"
                                   name="ejercicios[{{ $ejercicio->id }}][series]"
                                   value="{{ $pivot->series ?? '' }}"
                                   placeholder="Series"
                                   class="border rounded-lg p-2 w-full">

                            <input type="number"
                                   name="ejercicios[{{ $ejercicio->id }}][repeticiones]"
                                   value="{{ $pivot->repeticiones ?? '' }}"
                                   placeholder="Repeticiones"
                                   class="border rounded-lg p-2 w-full">

                            <input type="number"
                                   step="0.5"
                                   name="ejercicios[{{ $ejercicio->id }}][peso]"
                                   value="{{ $pivot->peso ?? '' }}"
                                   placeholder="Peso (kg)"
                                   class="border rounded-lg p-2 w-full">
                        </div>
                    </div>

                @endforeach

            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('buscador').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    document.querySelectorAll('.ejercicio-card').forEach(card => {
        let nombre = card.querySelector('.nombre-ejercicio').innerText.toLowerCase();
        card.style.display = nombre.includes(filtro) ? '' : 'none';
    });
});

document.querySelectorAll('.checkbox-ejercicio').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        let container = this.closest('.ejercicio-card');
        let inputs = container.querySelector('.inputs-ejercicio');

        if (this.checked) {
            inputs.classList.remove('hidden');
            container.classList.add('border-blue-400', 'bg-blue-50');
        } else {
            inputs.classList.add('hidden');
            container.classList.remove('border-blue-400', 'bg-blue-50');
        }
    });
});
</script>

@endsection
