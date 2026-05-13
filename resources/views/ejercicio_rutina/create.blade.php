@extends('layout')

@section('title', 'Añadir Ejercicios - BeStrong')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('rutinas.show', $rutina) }}"
           class="inline-flex items-center gap-2 text-gray-500 hover:text-red-500 font-medium">
            ← Volver a {{ $rutina->nombre }}
        </a>


    </div>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-red-500 px-8 py-6">
            <h1 class="text-2xl font-black text-white">Añadir Ejercicios</h1>
            <p class="text-red-100 text-sm mt-1">Rutina: {{ $rutina->nombre }}</p>
        </div>

        <form id="formEjercicios" action="{{ route('ejercicioRutina.create', $rutina) }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="flex gap-4 pt-4">
                
                <a href="{{ route('rutinas.show', $rutina) }}"
                class="px-6 py-4 border rounded-xl text-gray-600">
                Cancelar
                </a>

                <button type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-grey-600 font-bold py-4 px-6 rounded-xl shadow-lg"
                    @disabled($ejerciciosDisponibles->isEmpty())>
                    Guardar Ejercicios
                </button>
                
            </div>
            <div class="relative">
                <input type="text" id="buscador"
                       placeholder="Buscar ejercicio..."
                       class="w-full border rounded-xl p-3 pl-10 focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>

            @if($ejerciciosDisponibles->isEmpty())
                <p class="text-orange-500 font-semibold">
                    No hay ejercicios disponibles para añadir.
                </p>
            @else

                <div id="listaEjercicios" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">

                    @foreach($ejerciciosDisponibles as $ejercicio)
                        <div class="ejercicio-card border rounded-xl p-4 transition hover:shadow-md cursor-pointer">

                            <label class="flex items-center justify-between cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox"
                                           name="ejercicios[{{ $ejercicio->id }}][selected]"
                                           value="1"
                                           class="accent-red-500 checkbox-ejercicio">
                                    <span class="nombre-ejercicio font-semibold text-gray-800">
                                        {{ $ejercicio->nombre }}
                                    </span>
                                </div>

                                <span class="text-sm text-gray-400">Configurar →</span>
                            </label>

                            <div class="grid grid-cols-2 gap-3 mt-4 hidden inputs-ejercicio">

                                <input type="number"
                                       name="ejercicios[{{ $ejercicio->id }}][series]"
                                       placeholder="Series"
                                       class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-red-300">

                                <input type="number"
                                       name="ejercicios[{{ $ejercicio->id }}][repeticiones]"
                                       placeholder="Repeticiones"
                                       class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-red-300">

                                <input type="number"
                                       step="0.5"
                                       name="ejercicios[{{ $ejercicio->id }}][peso]"
                                       placeholder="Peso (kg)"
                                       class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-red-300">                           
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif
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
            container.classList.add('border-red-400', 'bg-red-50', 'shadow-md');
        } else {
            inputs.classList.add('hidden');
            container.classList.remove('border-red-400', 'bg-red-50', 'shadow-md');
        }
    });
});
</script>

@endsection
